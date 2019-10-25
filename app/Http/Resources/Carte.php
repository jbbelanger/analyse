<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Election as ElectionResource;

class Carte extends JsonResource
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
          'adoption' => $this->adoption,
          'annee' => $this->annee,
          'circonscriptions' => CirconscriptionResource::collection($this->whenLoaded('circonscriptions')),
          'elections' => ElectionResource::collection($this->whenLoaded('elections'))
        ];
    }
}
