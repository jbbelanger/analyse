<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\Sectionresultat as SectionresultatResource;

class Sectionparticipation extends JsonResource
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
          'bv' => $this->bv,
          'br' => $this->br,
          'ei' => $this->ei,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'election' => new ElectionResource($this->whenLoaded('election')),
          'section' => new SectionResource($this->whenLoaded('section')),
          'sectionresultats' => SectionresultatResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
