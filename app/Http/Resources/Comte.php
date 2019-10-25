<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Municipalite as MunicipaliteResource;
use App\Http\Resources\Region as RegionResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Comte extends JsonResource
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
          'nom' => $this->nom,
          'code' => $this->code,
          'chef_lieu' => new MunicipaliteResource($this->whenLoaded('chef_lieu')),
          'municipalites' => MunicipaliteResource::collection($this->whenLoaded('municipalites')),
          'region' => new RegionResource($this->whenLoaded('region')),
          'sections' => SectionResource::collection($this->whenLoaded('sections')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
