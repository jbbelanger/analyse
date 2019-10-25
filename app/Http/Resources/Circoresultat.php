<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Circoparticipation as CircoparticipationResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Parti as PartiResource;
use App\Http\Resources\Personne as PersonneResource;

class Circoresultat extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $params = [
          'c' => $this->circonscription_id,
          'e' => $this->election_id
        ];

        $hasSV = $this->circonscription()->whereHas('sectionresultats', function ($q) use ($params) {
          $q->where([
            ['circonscription_id', '=', $params['c']],
            ['election_id', '=', $params['e']]
          ]);
        })->count();


        return [
          //'id' => $this->id,
          'bv' => $this->bv,
          'rang' => $this->rang,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'election' => new ElectionResource($this->whenLoaded('election')),
          'parti' => new PartiResource($this->whenLoaded('parti')),
          'participation' => new CircoparticipationResource($this->whenLoaded('circoparticipation')),
          'personne' => new PersonneResource($this->whenLoaded('personne')),
          'sectionresultats' => $hasSV === 1 ? true : false
        ];
    }
}
