<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Apartment
 * @package App\Http\Resources
 */
class Apartment extends JsonResource
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
            'code' => $this->code,
            'number' => $this->number,
            'total_area' => $this->total_area,
            'bathroom_area' => $this->bathroom_area,
            'price' => $this->price,
            'images' => $this->images,
            'sectionnumber' => $this->sectionnumber,
            'decoration' => Decoration::make($this->decoration),
            'href' => route('apartment-detail', [$this->code]),
        ];
    }
}
