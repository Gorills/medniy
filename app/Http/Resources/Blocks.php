<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class MortgageTerms
 * @package App\Http\Resources
 */
class Blocks extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this);
        return [
            'data' => Block::collection($this),
        ];
    }

    /**
     * Work with request and response
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $response->header('Access-Control-Allow-Origin', '*');
    }
}
