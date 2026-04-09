<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.09.18
 * Time: 11:42
 */

namespace App\Console\Commands\App;

use Admin\Exceptions\ApartmentsImportException;
use App\Models\Block;
use Illuminate\Console\Command;
use App\Models\Apartment;
use App\Models\Scheme;
use App\Models\Decoration;
use App\Models\Floor;
use Illuminate\Support\Collection;

/**
 * Class ImportXML
 * @package App\Console\Commands\App
 */
class ImportXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Room data from mrk.capitalgroup.ru';

    /**
     * New admin credentials
     * @var array
     */
    protected $credentials;

    /** Import xml file
     * @var string
     */
    protected $importUrl = 'https://pics.capitalgroup.ru/pic/%D0%91%D0%BE%D0%B9/%D0%A0%D0%9A_%D0%A1%D0%B0%D0%B9%D1%82_%D0%9C%D0%B5%D0%B4%D0%BD%D1%8B%D0%B9.xml';

    /**
     *  permanent block id
     * @var int $blockId
     */
    protected $blockId = 1;

    /**
     * Array of error messages
     * @var array
     */
    protected $errorsArr = [];

    /**
     * @var Collection
     */
    protected $decorations;

    /**
     * @var Collection
     */
    protected $blocks;

    /**
     * All Schemes of floor
     * @var Collection
     */
    protected $schemes;

    /**
     * All floors
     * @var Collection
     */
    protected $floors;

    /**
     * All apartments
     * @var Collection
     */
    protected $apartments;

    /**
     * All floors from import file
     * @var array
     */
    protected $newFloors = [];

    protected $requiredCols = [
        'mcdsoft_price',
        'mcdsoft_price_meter',
        'mcdsoft_floor_height',
        'mcdsoft_whole_project_area',
        'mcdsoft_number_on_site',
        'mcdsoft_code',
        'mcdsoft_relevant_number',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Загрузка справочников из БД только при фактическом запуске команды (не в конструкторе),
     * иначе падает любой artisan (migrate, package:discover) при пустой БД.
     */
    private function loadImportCatalog(): void
    {
        $this->schemes = Scheme::where('active', true)->get();
        $this->decorations = Decoration::where('active', true)->get();
        $this->blocks = Block::get();
        $this->floors = Floor::get();
        $this->apartments = Apartment::get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->loadImportCatalog();

        try {
            $this->deactivate();
            $this->import();
        } catch (ApartmentsImportException $exception) {
            foreach ($exception->getErrorsMessages() as $errorsMessage) {
                print('Apartments import: ' . $errorsMessage . PHP_EOL);
            }
        }
        return 0;
    }

    private function deactivate()
    {
        $this->deactivateElements($this->floors);
        $this->deactivateElements($this->apartments);
    }

    /**
     * Runs import
     * @throws ApartmentsImportException
     */
    private function import()
    {
        $total = 0;
        $error = 0;
        $imported = 0;

        $xml = simplexml_load_file($this->importUrl, 'SimpleXmlElement');
        $xmlToArray = json_decode(json_encode($xml), TRUE);

        $house = $xmlToArray['mcdsoft_apartment_complex']['mcdsoft_house'];
        $sections = $house['mcdsoft_section'];

        if (array_key_exists('mcdsoft_sectionid', $sections)) { // на тот случай, если всего одна секция в доме
	        for ($j = 0, $jMax = count($sections['mcdsoft_property']); $j < $jMax; $j++) {
		        if (array_key_exists('mcdsoft_propertyid', $sections['mcdsoft_property'])) { // на тот случай, если всего одна квартира в секции
			        $apartments[] = $sections['mcdsoft_property'];
			        break;
		        }

		        if (isset($sections['mcdsoft_property'][$j])) { // если более 1 квартиры в секции
			        $apartments[] = $sections['mcdsoft_property'][$j];
		        }
	        }
        } else { // если более одной секции в доме
	        foreach ($sections as $i => $iValue) {
		        for ($j = 0, $jMax = count($iValue['mcdsoft_property']); $j < $jMax; $j++) {
			        if (array_key_exists('mcdsoft_propertyid', $iValue['mcdsoft_property'])) { // на тот случай, если всего одна квартира в секции
				        $apartments[] = $sections[$i]['mcdsoft_property'];
				        break;
			        }

			        if (isset($iValue['mcdsoft_property'][$j])) { // если более 1 квартиры в секции
				        $apartments[] = $sections[$i]['mcdsoft_property'][$j];
			        }
		        }
	        }
        }

        if (empty($xmlToArray['mcdsoft_apartment_complex'])) {
            $this->addErrorMessage('Файл пустой');
        }

        if (!empty($this->getErrorsArr())) {
            throw new ApartmentsImportException($this->getErrorsArr());
        }

        /** @var \SimpleXmlElement $apartment */
        foreach ($apartments as $apartment) {
            $total++;
            foreach ($this->requiredCols as $columnName) {
                if (!array_key_exists($columnName, $apartment)) {
                    $this->addErrorMessage('Недостаточно данных ' . $columnName . ' (' . $apartment. ')');
                    $error++;
                    continue 2;
                }
            }

            $korpusId = (int)$apartment['mcdsoft_section_number'];
            $schemeId = (int)$apartment['mcdsoft_section_number'];

            /**
             * in this case 'id' field of block equals 'tisa_publicity.tisa_korpus' field from import
             */
            $blockId = $this->blocks->firstWhere('id', $korpusId)->id;
            $obFloor = $this->floors->where('number', $apartment['mcdsoft_floor_height'])->where('block_id', $blockId)->first();
            if ($obFloor === null) {
                $obFloor = new Floor();
                $obFloor->active = true;
                $obFloor->block_id = $blockId;
                $obFloor->number = $apartment['mcdsoft_floor_height'];
                $obFloor->scheme_id = $schemeId;
                $obFloor->save();
                // append new element to collection
                $this->floors[] = $obFloor;
            } else {
                $obFloor->active = true;
                $obFloor->block_id = $blockId;
                $obFloor->number = $apartment['mcdsoft_floor_height'];
                $obFloor->scheme_id = $schemeId;
                $obFloor->save();
            }

            /**
             * @var Apartment $obApartment
             */
            $obApartment = $this->apartments->where('code', $apartment['mcdsoft_code'])->first();
            $decorationId = 1;

            if ($apartment['mcdsoft_number_on_site']) {
                $decorationId = $this->decorations->firstWhere('code', $apartment['mcdsoft_number_on_site'])->id;
            }

            if ($obApartment === null) {
                $obApartment = new Apartment();
                $obApartment->block_id = $blockId;
                $obApartment->sectionnumber = '';
            }

            $obApartment->active = true;
            $obApartment->floor_id = $obFloor->id;
            $obApartment->number = $apartment['mcdsoft_relevant_number'];
            $obApartment->code = $apartment['mcdsoft_code'];

            $cost = preg_replace("/[^,.0-9]/", '', $apartment['mcdsoft_price_meter']);
            $price = preg_replace("/[^,.0-9]/", '', $apartment['mcdsoft_price']);

            $obApartment->rooms = $apartment['mcdsoft_number_rooms'];
            $obApartment->total_area = str_replace(",", ".", $apartment['mcdsoft_whole_project_area']);
            $obApartment->cost = str_replace(",", ".", $cost);
            $obApartment->price = str_replace(",", ".", $price);
            $obApartment->images = $apartment['mcdsoft_photos']['mcdsoft_photo'] ?? '';
            $obApartment->decoration_id = $decorationId;

            $obApartment->save();
            $imported++;
        }

        print 'Total ' . $total . ' apartments' . PHP_EOL;
        print 'Error ' . $error . ' apartments' . PHP_EOL;
        print 'Imported ' . $imported . ' apartments' . PHP_EOL;

        if (!empty($this->getErrorsArr())) {
            throw new ApartmentsImportException($this->getErrorsArr());
        }
    }

    /**
     * @param string $message
     */
    public function addErrorMessage(string $message)
    {
        $this->errorsArr[] = $message;
    }

    /**
     * Returns errors messages array
     * @return array
     */
    public function getErrorsArr(): array
    {
        return $this->errorsArr;
    }

    protected function deactivateElements($ob)
    {
        $ob->each(function ($model) {
            $model->active = false;
            $model->save();
        });
    }


    protected function parseDocument()
    {


        return;
    }
}
