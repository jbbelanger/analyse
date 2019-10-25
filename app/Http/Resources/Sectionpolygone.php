<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Section as SectionResource;

class Sectionpolygone extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'polygone' => $this->polygone,
          'section' => new SectionResource($this->whenLoaded('section'))
        ];
    }
}
