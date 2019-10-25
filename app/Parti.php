<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parti extends Model
{
	public function candidatures()
	{
		return $this->hasManyThrough(
			'\App\Personne',
			'\App\Circoresultat',
			'parti_id',
			'id',
			'id',
			'personne_id'
		)->distinct();
	}

	public function circoresultats()
	{
		return $this->hasMany('\App\Circoresultat');
	}

  public function deputes()
	{
    return $this->hasManyThrough(
      '\App\Personne',
      '\App\Circoresultat',
      'parti_id',
      'id',
      'id',
      'personne_id'
    )->where('rang',1)->distinct();
	}

  public function sections()
	{
    return $this->hasManyThrough(
      '\App\Section',
      '\App\Circoresultat',
      'parti_id',
      'id',
      'id',
      'section_id'
    )->distinct();
	}

	public function sectionresultats()
	{
		return $this->hasMany('\App\Sectionresultat');
	}
}
