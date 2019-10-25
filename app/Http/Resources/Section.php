<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Legislature as LegislatureResource;
use App\Http\Resources\Municipalite as MunicipaliteResource;
use App\Http\Resources\Sectionparticipation as SectionparticipationResource;
use App\Http\Resources\SectionparticipationGrouped;
use App\Http\Resources\Sectionpolygone as SectionpolygoneResource;
use App\Http\Resources\SectionresultatsgroupeCollection;
use App\Http\Resources\Sectionresultatsgroupes as SectionresultatgroupesResource;

class Section extends JsonResource
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
          'description' => $this->description,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
          'legislature' => new LegislatureResource($this->whenLoaded('legislature')),
          'municipalite' => new MunicipaliteResource($this->whenLoaded('municipalite')),
          'participation' => new SectionparticipationGrouped($this->whenLoaded('sectionparticipation')),
          'polygone' => new SectionpolygoneResource($this->whenLoaded('sectionpolygone')),
          'resultats' => SectionresultatgroupesResource::collection($this->whenLoaded('sectionresultats'))
        ];
    }
}
