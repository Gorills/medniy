<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Floor
 * @package App\Http\Resources
 */
class Floor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'apartments' => Apartment::collection($this->apartments),
            'scheme' => Scheme::make($this->scheme),
        ];
    }
}
