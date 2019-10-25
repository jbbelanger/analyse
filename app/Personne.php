<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Personne extends Model
{
  use SoftDeletes;
  use Searchable;

  public function relationables()
  {
    return [
      'circonscriptions' => function () {},
      'circonscriptions.region' => function () {},
      'elections' => function () {},
      'partis' => function () {},
      'circoresultats' => function () {},
    ];
  }

  public function circonscriptions()
  {
    return $this->hasManyThrough(
      '\App\Circonscription',
      '\App\Circoresultat',
      'personne_id',
      'id',
      'id',
      'circonscription_id'
    )->distinct();
	}

	public function circoresultats()
  {
  	return $this->hasMany('\App\Circoresultat');
  }

  public function elections()
  {
    return $this->hasManyThrough(
      '\App\Election',
      '\App\Circoresultat',
      'personne_id',
      'id',
      'id',
      'election_id'
    )->distinct()->orderBy('date');
	}

  public function partis()
  {
    return $this->hasManyThrough(
      '\App\Parti',
      '\App\Circoresultat',
      'personne_id',
      'id',
      'id',
      'parti_id'
    )->distinct();
	}

	public function sectionresultats()
  {
		return $this->hasMany('\App\Sectionresultat');
	}
}
