<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Floor;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use PDF;

/**
 * Class ConstructionStagesController
 * @package App\Http\Controllers
 */
class ApartmentController extends Controller
{
    public function getBuildingsList()
    {

        $blocks = Block::where('active', true)
            ->with(['apartments' => function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('active', true);
                $query->orderBy('rooms', 'asc');
            }])->get();


        $blocksFlatsExist = []; // корпусы, которые нужно дизаблить, если в них нет квартир
        foreach ($blocks as &$block) {
            /**
             * @var Collection $ap
             */

            if (0 === \count($block->apartments)) {
                if (!in_array($block->number, $blocksFlatsExist)) {
                    $blocksFlatsExist[] = $block->number;
                }
            }

            $block->apartments = $block->apartments->groupBy(
                [
                    'rooms' => function ($item) {
                        return $item->rooms;
                    }
                ],
                $preserveKeys = true
            );

            $block->firstFloor=false;
            if ($firstFloor=Floor::query()
                ->where('block_id', $block->id)
                ->where('active', 1)
                ->orderBy('number')
                ->first()){
                $block->firstFloor=$firstFloor->number;
            }

            foreach ($block->apartments as $num => $col) {
                $col->min_price = round($col->min('price') / 1e6, 1);
                $col->min_area = $col->min('total_area');
                $col->max_area = $col->max('total_area');
            }
        }

        return view(
            'pages.blocks',
            [
                'blocks' => $blocks,
                'blocksFlatsExist' => $blocksFlatsExist,
                'pageTitle' => 'Новостройка на Донской 14, м Шаболовская, Парк Горького - ЖК Медный 3.14',
                'pageDescription' => 'Подбор квартир в корпусах нового жилого комплекса премиум-класса Медный 3.14 на Донской 14 по генплану',
                'pageKeywords' => 'генплан, новостройка, жилой коплекс, подбор квартир, донская 14, шаболовская, парк горького, жк медный 3.14',
            ]
        );
    }

    /**
     * @param $block
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBuilding($block)
    {
        /**
         * @var Collection $building
         */
        $block = Block::where('active', true)
            ->where('number', $block)
            ->with(['floors' => function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('active', true);
            }])
            ->first();

        if (!$block) {
            abort('404');
        }

        return view('pages.building-block', [
                'block' => $block,
                'pageTitle' => 'Корпус '.$block->number.' жилого комплекса премиум-класса Медный 3.14',
                'pageDescription' => 'Квартиры в доме на Донской 14 корпус '.$block->id.' жилого комплекса премиум класса Медный 3.14. Телефон отдела продаж: +7 (495) 023-78-37',
                'pageKeywords' => 'подбор квартир, выбор этажа, жк медный 3.14, донская 14, донской район, шаболовка, москва',
            ]
        );
    }

    public function getFloor($block, $floor)
    {

        $floor = Floor::where('number', $floor)
            ->whereHas(
                'block',
                function ($query) use ($block) {
                    /**
                     * @var BelongsTo $query
                     */
                    $query->where('active', true);
                    $query->where('number', $block);
                }
            )
            ->with('block')
            ->with('scheme')
            ->first();


        if (!$floor) {
            abort('404');
        }

        $block = Block::query()->where('number', $block)->where('active', true)->first();

        $apartments = Apartment::query()->where('block_id', $block->id)
            ->where('floor_id', $floor->id)
            ->orderBy('code', 'asc')
            ->get();

        $prevBlock = Block::query()->where('active', true)->where('id', '<', $floor->block->id)->first();
        $nextBlock = Block::query()->where('active', true)->where('id', '>', $floor->block->id)->first();

        $floorPrev = Floor::query()->where('number', '<', $floor->number)
            ->where('block_id', $block->id)
            ->where('active', true)
            ->orderBy('number', 'desc')
            ->first();

        $floorNext = Floor::query()->where('number', '>', $floor->number)
            ->where('block_id', $block->id)
            ->where('active', true)
            ->orderBy('number', 'asc')
            ->first();

        $prevBlockFloor = null;
        $nextBlockFloor = null;
        if (null !== $prevBlock) {
            $prevBlockFloor = $prevBlock->floors->where('active', 1)->where('number', '<=', $floor->number)->sortByDesc('number')->first();

            if (null === $prevBlockFloor) {
                $prevBlockFloor = $prevBlock->floors->where('active', 1)->sortBy('number')->first();
            }
        }

        if (null !== $nextBlock) {
            $nextBlockFloor = $nextBlock->floors->where('active', 1)->where('number', '<=', $floor->number)->sortByDesc('number')->first();

            if (null === $nextBlockFloor) {
                $nextBlockFloor = $nextBlock->floors->where('active', 1)->sortBy('number')->first();
            }
        }

        if ($_SERVER['REMOTE_ADDR'] === '46.148.196.76') {
//            dd($nextBlockFloor);
        }

        $data = [
            'apartments' => $apartments,
            'floor' => $floor,
            'floors' => [
                'prev' => $floorPrev,
                'next' => $floorNext,
            ],
            'blocks' => [
                'all' => Block::query()->orderBy('order', 'asc')->get(),
                'prev' => $prevBlock,
                'next' => $nextBlock,
            ],
            'blocks2floor' => [
                'all' =>  Block::query()->with('floors')->where('active', 1)->orderBy('order', 'asc')->get(),
                'prev' => $prevBlockFloor,
                'next' => $nextBlockFloor,
            ],
            'pageTitle' => 'Корпус '.$block->number.' - Этаж '.$floor->number.' - ЖК Медный 3.14',
            'pageDescription' => 'Подбор квартир в корпусе '.$block->number.', на '.$floor->number.' этаже жилого комплекса премиум-класса Медный 3.14. Телефон отдела продаж: +7 (495) 023-78-37',
            'pageKeywords' => 'подбор квартир, выбор этажа, жк медный 3.14, донская 14, донской район, шаболовка, москва',
        ];
//        dd($data);
        return view('pages.floor', $data);
    }

    public function getApartment($block, $floor, $apartment)
    {

        $apartment = Apartment::where('active', true)
            ->where('number', $apartment)
            ->whereHas(
                'floor',
                function ($query) use ($floor, $block) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query->where('active', true);
                    $query->where('number', $floor);

                    $query->whereHas(
                        'block',
                        function ($query1) use ($block) {
                            /** @var \Illuminate\Database\Eloquent\Builder $query1 */
                            $query1->where('active', true);
                            $query1->where('number', $block);
                        }
                    );
                }
            )
            ->with('floor.block')
            ->with('floor')
            ->first();
        if (!$apartment) {
            abort('404');
        }
        return view('pages.apartment', ['apartment' => $apartment]);
    }

    public function detailApartment($apartment)
    {
        $apartment = Apartment::where('active', true)
            ->where('code', $apartment)
            ->with('floor.block')
            ->with('decoration')
            ->with('floor')
            ->first();

        if (!$apartment) {
            abort('404');
        }
        $room_num=[
            1=>'одно',
            2=>'двух',
            3=>'трех',
            4=>'четырех',
        ];
        return view('pages.apartment', [
                'apartment' => $apartment,
                'pageTitle' => 'Купить '.$apartment->rooms.' – комнатную квартиру на Донской 14, '.$apartment->total_area.' м² в ЖК Медный 3.14',
                'pageDescription' => 'Купить '.$room_num[$apartment->rooms].'комнатную квартиру на Донской 14, площадью '.$apartment->total_area.' м², в районе м Шаболовская в ЖК Медный 3.14. Отдел продаж: +7 (495) 023-78-37',
                'pageKeywords' => 'купить квартиру, апартаменты, пентхаус, донская 14, шаболовка, шаболовская, донской район, жк медный 3.14',
            ]
        );
    }

    public function detailApartmentPdf($apartment)
    {
        $apartment = Apartment::where('active', true)
            ->where('code', $apartment)
            ->with('floor.block')
            ->with('decoration')
            ->with('floor')
            ->first();

        if (!$apartment) {
            abort('404');
        }
        $block=$apartment->floor->block->number;
        $floor = Floor::where('number', $apartment->floor->number)
            ->whereHas(
                'block',
                function ($query) use ($block) {
                    /**
                     * @var BelongsTo $query
                     */
                    $query->where('active', true);
                    $query->where('number', $block);
                }
            )
            ->with('block')
            ->with('scheme')
            ->first();
        $apartment->imageBase64 = base64_encode(file_get_contents($this->getImg($apartment, $floor)));
        /** @var \niklasravnsborg\LaravelPdf\Pdf $pdf */
        $pdf = PDF::loadView('pages.apartment-pdf', ['apartment' => $apartment], [], 'UTF-8');
        return $pdf->stream();
//        return view('pages.apartment-pdf', ['apartment' => $apartment]);
    }

    // преобразовываем svg для PDF
    public function getImg($apartment, $floor)
    {
        // определяем ключ квартиры в svg  (data-key)
        $apartments = Apartment::query()->where('block_id', $apartment->floor->block->id)
            ->where('floor_id', $floor->id)
            ->orderBy('code', 'asc')
            ->get();
        foreach ($apartments as $index => $item) {
            if ($item->code == $apartment->code) {
                $key=$index;
            }
        }
        return 'https://'.$_SERVER['HTTP_HOST'].'/pdf/images/detail-'.$apartment->floor->block->id.'-'.$key.'.png';
    }

    public function apatrmentSelection()
    {
        /** @var Builder $apartments */
        $apartments = Apartment::where('active', true)
            ->with('decoration');

        $filter = [
            'blocks' => [],
            'rooms' => [],
            'decorations' => [],
            'square' => [
                'min' => 0,
                'max' => 0,
            ],
            'price' => [
                'min' => 0,
                'max' => 0,
            ],
            'current' => [
                'blocks' => [],
                'rooms' => [],
                'decorations' => [],
                'square' => [
                    'min' => 0,
                    'max' => 0,
                ],
                'price' => [
                    'min' => 0,
                    'max' => 0,
                ],
            ]
        ];

        $apartmentsFilter = $apartments->get();
        foreach ($apartmentsFilter as $apartment) {
            $filter['blocks'][$apartment->floor->block->id] = $apartment->floor->block->number;
            $filter['rooms'][$apartment->rooms] = $apartment->rooms;
            $filter['decorations'][$apartment->decoration->id] = $apartment->decoration->name;

            if ($filter['square']['min'] == 0) {
                $filter['square']['min'] = $apartment->total_area;
            }
            if ($filter['square']['max'] == 0) {
                $filter['square']['max'] = $apartment->total_area;
            }

            if ($apartment->total_area < $filter['square']['min']) {
                $filter['square']['min'] = $apartment->total_area;
            }

            if ($apartment->total_area > $filter['square']['max']) {
                $filter['square']['max'] = $apartment->total_area;
            }

            if ($filter['price']['min'] == 0) {
                $filter['price']['min'] = $apartment->price;
            }
            if ($filter['price']['max'] == 0) {
                $filter['price']['max'] = $apartment->price;
            }

            if ($apartment->price < $filter['price']['min']) {
                $filter['price']['min'] = $apartment->price;
            }

            if ($apartment->price > $filter['price']['max']) {
                $filter['price']['max'] = $apartment->price;
            }
        }
        if (!empty($filter['rooms'])) {
            sort($filter['rooms']);
        }
//        dd($filter);

        if (request()->input('filter') == 'Y') {
            if (request()->input('price')) {
                $apartments
                    ->whereBetween('price', [
                        request()->input('price')['min'],
                        request()->input('price')['max'],
                    ]);

                $filter['current']['price']['min'] = request()->input('price')['min'];
                $filter['current']['price']['max'] = request()->input('price')['max'];

            }

            if (request()->input('square')) {
                $apartments
                    ->whereBetween('total_area', [
                        request()->input('square')['min'],
                        request()->input('square')['max']
                    ]);

                $filter['current']['square']['min'] = request()->input('square')['min'];
                $filter['current']['square']['max'] = request()->input('square')['max'];

            }

            if (request()->input('blocks')) {
                $apartments
                    ->whereIn('block_id', request()->input('blocks'));
                $filter['current']['blocks'] = request()->input('blocks');
            }

            if (request()->input('rooms')) {
                $apartments
                    ->whereIn('rooms', request()->input('rooms'));
                $filter['current']['rooms'] = request()->input('rooms');
            }

            if (request()->input('decorations')) {
                $apartments
                    ->whereIn('decoration_id', request()->input('decorations'));
                $filter['current']['decorations'] = request()->input('decorations');
            }
        }

        if ($filter['current']['square']['min'] == 0) {
            $filter['current']['square']['min'] = $filter['square']['min'];
        }
        if ($filter['current']['square']['max'] == 0) {
            $filter['current']['square']['max'] = $filter['square']['max'];
        }

        if ($filter['current']['price']['min'] == 0) {
            $filter['current']['price']['min'] = $filter['price']['min'];
        }
        if ($filter['current']['price']['max'] == 0) {
            $filter['current']['price']['max'] = $filter['price']['max'];
        }

        $apartments = $apartments->get();

        $floors = Floor::query()
            ->with('block')
            ->orderBy('number', 'desc')
            ->get();

        $tpmFloors = [];

        foreach ($floors as $floor) {
            $tpmFloors[$floor->block->number][$floor->number] = $floor;
        }
        $result = request()->session()->all();//получаем данные из сессии
        $token = $result['_token'];

//        dd(request()->cookie());

        return view('pages.apartment-selection', [
            'filter' => $filter,
            'apartments' => $apartments,
            'floors' => $tpmFloors,
            'token' => $token,
            'pageTitle' => 'Купить квартиру на Донской улице в районе м Шаболовская в Москве - ЖК Медный 3.14',
            'pageDescription' => 'Подбор квартир по параметрам в ЖК Медный 3.14 на Донской. Телефон отдела продаж: +7 (495) 023-78-37',
            'pageKeywords' => 'подбор квартир, параметры, выбор этажа, количество спален, жк медный 3.14, донская 14, москва, донской район, шаболовка',
        ]);
    }


}
