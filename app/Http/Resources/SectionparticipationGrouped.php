<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Sectionparticipation;

class SectionparticipationGrouped extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $grouped = [];

        if (isset($this->first()->election_id) && isset($this->first()->section_id)) {
          $grouped = Sectionparticipation::selectRaw('sum(distinct bv) bv,
          sum(distinct br) br,
          sum(distinct ei) ei')
          ->where([
            ['election_id', $this->first()->election_id],
            ['section_id', $this->first()->section_id]
          ])
          ->groupBy('section_id', 'election_id')
          ->get();
        }

        //dump($grouped[0]->bv);

        if (count($grouped) > 0) {
          return [
            'bv' => (int) $grouped[0]->bv,
            'br' => (int) $grouped[0]->br,
            'ei' => (int) $grouped[0]->ei
          ];
        }
    }
}
