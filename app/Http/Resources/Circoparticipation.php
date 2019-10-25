<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\Election as ElectionResource;

class Circoparticipation extends JsonResource
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
          //'id' => $this->id,
          'bv' => $this->bv,
          'br' => $this->br,
          'ei' => $this->ei,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'election' => new ElectionResource($this->whenLoaded('election')),
          'circoresultats' => CircoresultatResource::collection($this->whenLoaded('circoresultats'))
        ];
    }
}
