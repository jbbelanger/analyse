<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circonscription as CirconscriptionResource;

class Circopolygone extends JsonResource
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
          'polygone' => $this->polygone,
          'circonscription' => new CirconscriptionResource($this->whenLoaded('circonscription')),
        ];
    }
}
