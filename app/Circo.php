<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circo extends Model
{
  use SoftDeletes;

  public function relationables()
  {
    return [
      'circonscriptions' => function () {},
      'circonscriptions.carte' => function () {},
      'circonscriptions.elections' => function () {},
      'elections' => function () {},
      'elections.circonscriptions' => function () {},
      'elections.circoresultatsgroupes' => function () {},
      'elections.circoresultatsgroupes.parti' => function () {},
      'region' => function () {},
      'tags' => function () {},
    ];
  }

	public function circonscriptions() {
		return $this->belongsToMany('\App\Circonscription');
	}

  public function elections() {
		return $this->belongsToMany('\App\Election')->orderBy('date');
	}

  public function region() {
    return $this->belongsTo('\App\Region','region_id');
  }

  public function tags() {
		return $this->belongsToMany('\App\Tag');
	}
}
