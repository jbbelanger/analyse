<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Carte as CarteResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\Circoresultatsgroupe as CircoresultatsgroupeResource;
use App\Http\Resources\Legislature as LegislatureResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Election extends JsonResource
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
          'type' => $this->type,
          'date' => $this->date,
          'carte' => new CarteResource($this->whenLoaded('carte')),
          'circonscriptions' => CirconscriptionResource::collection($this->whenLoaded('circonscriptions')),
          'circoresultats' => CircoresultatResource::collection($this->whenLoaded('circoresultats')),
          'circoresultatsgroupes' => CircoresultatsgroupeResource::collection($this->whenLoaded('circoresultatsgroupes')),
          'legislature' => new LegislatureResource($this->whenLoaded('legislature')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
