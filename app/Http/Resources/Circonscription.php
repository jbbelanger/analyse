<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Carte as CarteResource;
use App\Http\Resources\Circo as CircoResource;
use App\Http\Resources\Circopolygone as CircopolygoneResource;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Region as RegionResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Circonscription extends JsonResource
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
          'determinant' => $this->determinant,
          'carte' => new CarteResource($this->whenLoaded('carte')),
          'circos' => CircoResource::collection($this->whenLoaded('circos')),
          'circopolygone' => new CircopolygoneResource($this->whenLoaded('circopolygone')),
          'circoresultats' => CircoresultatResource::collection($this->whenLoaded('circoresultats')),
          'elections' => ElectionResource::collection($this->whenLoaded('elections')),
          'region' => new RegionResource($this->whenLoaded('region')),
          'sections' => SectionResource::collection($this->whenLoaded('sections')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
