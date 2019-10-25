<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comte extends Model
{

  public function chef_lieu()
  {
    return $this->belongsTo('\App\Municipalite','capitale_id');
  }

  public function municipalites()
  {
    return $this->hasMany('\App\Municipalite');
  }

  public function region()
  {
    return $this->belongsTo('\App\Region');
  }

  public function sections()
  {
    return $this->hasManyThrough(
      '\App\Section',
      '\App\Municipalite',
      'comte_id',
      'municipalite_id',
      'id',
      'id'
    )->distinct();
	}

  public function sectionresultats()
  {
    return $this->hasMany('\App\Sectionresultat');
  }

}
