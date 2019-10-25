<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Municipalite as MunicipaliteResource;
use App\Http\Resources\Parti as PartiResource;
use App\Http\Resources\Personne as PersonneResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionparticipation as SectionparticipationResource;

class Sectionresultatsgroupes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        //$this->dd();
        return [
          'bv' => (int) $this->where([['parti_id',$this->parti_id], ['election_id', $this->election_id], ['section_id', $this->section_id]])->sum('bv'),
          'circorang' => (int) $this->circorang,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'election' => new ElectionResource($this->whenLoaded('election')),
          'municipalite' => new MunicipaliteResource($this->whenLoaded('municipalite')),
          'parti' => new PartiResource($this->whenLoaded('parti')),
          'personne' => new PersonneResource($this->whenLoaded('personne')),
          'section' => new Section($this->whenLoaded('section')),
          'participation' => new Sectionparticipation($this->whenLoaded('sectionparticipation'))
        ];
    }
}
