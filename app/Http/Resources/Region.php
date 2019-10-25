<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circo as CircoResource;
use App\Http\Resources\Comte as ComteResource;
use App\Http\Resources\Municipalite as MunicipaliteResource;

class Region extends JsonResource
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
          'code' => $this->code,
          'nom' => $this->nom,
          'circos' => CircoResource::collection($this->whenLoaded('circos')),
          'comtes' => ComteResource::collection($this->whenLoaded('comtes')),
          'municipalites' => MunicipaliteResource::collection($this->whenLoaded('municipalitess'))
        ];
    }
}
