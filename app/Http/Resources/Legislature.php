<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Election as ElectionResource;

class Legislature extends JsonResource
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
          'ouverture' => $this->ouverture,
          'dissolution' => $this->dissolution,
          'elections' => ElectionResource::collection($this->whenLoaded('elections'))
        ];
    }
}
