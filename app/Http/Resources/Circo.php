<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\Election as ElectionResource;
use App\Http\Resources\Region as RegionResource;

class Circo extends JsonResource
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
          'determinant' => $this->determinant,
          'circonscriptions' => CirconscriptionResource::collection($this->whenLoaded('circonscriptions')),
          'elections' => ElectionResource::collection($this->whenLoaded('elections')),
          'region' => new RegionResource($this->whenLoaded('region')),
        ];
    }
}
