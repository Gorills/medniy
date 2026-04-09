<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Scheme
 * @package App\Http\Resources
 */
class Scheme extends JsonResource
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
            'scheme_svg' => $this->scheme_svg,
            'scheme_img' => $this->scheme_img,
        ];
    }
}
