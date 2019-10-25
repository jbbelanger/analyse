<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Circo as CircoResource;
use App\Http\Resources\Tag as TagResource;

class Tag extends JsonResource
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
          'circos' => CircoResource::collection($this->whenLoaded('circos')),
          'parent' => new TagResource($this->whenLoaded('parent')),
          'children' => TagResource::collection($this->whenLoaded('children'))
        ];
    }
}
