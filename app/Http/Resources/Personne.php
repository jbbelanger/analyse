<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Parti as PartiResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Personne extends JsonResource
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
          'prenom' => $this->prenom,
          'nom' => $this->nom,
          'genre' => $this->genre,
          'naissance' => $this->naissance,
          'deces' => $this->deces,
          'circonscriptions' => CirconscriptionResource::collection($this->whenLoaded('circonscriptions')),
          'circoresultats' => CircoresultatResource::collection($this->whenLoaded('circoresultats')),
          'elections' => ElectionResource::collection($this->whenLoaded('elections')),
          'partis' => PartiResource::collection($this->whenLoaded('partis')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
