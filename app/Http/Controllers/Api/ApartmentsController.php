<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Floor;
use Illuminate\Support\Collection;

/**
 * Class ConstructionStagesController
 * @package App\Http\Controllers
 */
class ApartmentsController extends Controller
{
    public function getBuildingsList()
    {
        $blocks = Block::where('active', true)
            ->with(['floors' => function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('active', true);
                $query->with('scheme');
                $query->with(['apartments' => function ($query1) {
                    $query1->where('active', true);
                    $query1->with('decoration');
                }]);
            }])
            ->get();
        $obBlocks = new \App\Http\Resources\Blocks(
            $blocks
        );
        return $obBlocks;
        return view('pages.json-blocks', ['obBlocks' => $obBlocks]);

    }

    public function apatrmentSelection()
    {
        $apartments = Apartment::where('active', true)
            ->with('floor.block')
            ->with('decoration')
            ->get();
        return new \App\Http\Resources\Apartments(
            $apartments
        );

        dd($apartments->toJson());
        return view('pages.apartment-selection', ['apartments' => $apartments]);
    }


}
