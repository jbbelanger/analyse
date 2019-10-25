<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\Personne as PersonneResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Parti extends JsonResource
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
          'nom_officiel' => $this->nom_officiel,
          'nom_usuel' => $this->nom_usuel,
          'abb_officielle' => $this->abb_officielle,
          'abb_usuelle' => $this->abb_usuelle,
          'couleur' => $this->couleur,
          'candidatures' => PersonneResource::collection($this->whenLoaded('candidatures')),
          'circoresultats' => CircoresultatResource::collection($this->whenLoaded('circoresultats')),
          'deputes' => PersonneResource::collection($this->whenLoaded('deputes')),
          'sections' => SectionResource::collection($this->whenLoaded('sections')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
