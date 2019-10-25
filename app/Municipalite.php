<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipalite extends Model
{

  public function comte()
  {
    return $this->belongsTo('\App\Comte');
  }

  public function region()
  {
    return $this->belongsTo('\App\Region');
  }

  public function sections()
  {
    return $this->hasMany('\App\Section');
  }

  public function sectionresultats()
  {
    return $this->hasManyThrough('\App\Sectionresultat','\App\Section');
  }
}
