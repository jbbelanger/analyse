<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comte as ComteResource;
use App\Http\Resources\Region as RegionResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Municipalite extends JsonResource
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
          'code' => $this->code,
          'nom' => $this->nom,
          'type' => $this->type,
          'comte' => new ComteResource($this->whenLoaded('comte')),
          'region' => new RegionResource($this->whenLoaded('region')),
          'sections' => SectionResource::collection($this->whenLoaded('sections')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
