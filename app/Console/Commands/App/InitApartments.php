<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.18
 * Time: 14:50
 */

namespace App\Console\Commands\App;

use App\Models\Apartment;
use App\Models\Floor;
use Illuminate\Console\Command;

class InitApartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initApartments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add empty apartments';


    private $cntFloors = [
        1 => 21,
        2 => 9,
        3 => 16
    ];

    private $cntApparts = [
        1 => 2,
        2 => 3,
        3 => 5
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for ($blockId=3; $blockId <=3; $blockId++) {
            $schemeId = $blockId;
            for ($floorNum = 3; $floorNum <= $this->cntFloors[$blockId]; $floorNum++) {
                $obFloor = Floor::where('block_id', $blockId)
                    ->where('number', $floorNum)->first();

                if ($obFloor === null) {
                    $obFloor = new Floor();
                    $obFloor->active = false;
                    $obFloor->block_id = $blockId;
                    $obFloor->number = $floorNum;
                    $obFloor->scheme_id = $schemeId;
                    $obFloor->save();

                    $this->info('Added floor #' . $floorNum . ' fro block ' . $blockId);
                }

                for ($k = 1; $k <= $this->cntApparts[$blockId]; $k++) {
                    $number = $k + ($floorNum-2)*$this->cntApparts[$blockId] - $this->cntApparts[$blockId];
                    $code = sprintf('Дн-1-1-%02d-%02d-%02d', $blockId, $floorNum, $k);

                    $obApartment = Apartment::where('code', $code)->first();

                    if ($obApartment === null) {
                        $obApartment = new Apartment();

                        $obApartment->block_id = $blockId;
                        $obApartment->sectionnumber = '';
                        $obApartment->active = false;
                        $obApartment->floor_id = $obFloor->id;
                        $obApartment->number = $number;
                        $obApartment->code = $code;
                        // default values
                        $obApartment->decoration_id = 1;
                        $obApartment->rooms = 1;
                        $obApartment->total_area = 1;
                        $obApartment->bathroom_area = 1;
                        $obApartment->kitchen = 1;
                        $obApartment->cost = 1;
                        $obApartment->price = 1;
                        $obApartment->images = '';
                        // default values
                        $obApartment->save();
                        $this->warn('Added apartment #' . $number . ' fro block ' . $blockId);
//                        $this->warn($code . ' ' . $number);
                    }
                }
            }
        }
        return;
    }
}
