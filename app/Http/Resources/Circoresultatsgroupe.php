<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Circoparticipation as CircoparticipationResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Parti as PartiResource;
use App\Http\Resources\Personne as PersonneResource;

class Circoresultatsgroupe extends JsonResource
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
          'bv' => $this->bv,
          'rang' => $this->rang,
          'participation' => [
            'bv' => $this->pr_bv,
            'br' => $this->pr_br,
            'ei' => $this->pr_ei
          ],
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'election' => new ElectionResource($this->whenLoaded('election')),
          'parti' => new PartiResource($this->whenLoaded('parti')),
          'personne' => new PersonneResource($this->whenLoaded('personne'))
        ];
    }
}
