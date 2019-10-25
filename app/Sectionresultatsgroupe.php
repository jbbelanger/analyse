<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectionresultatsgroupe extends Model
{
    public function circonscription()
    {
      return $this->belongsTo('\App\Circonscription');
    }

    public function election()
    {
      return $this->belongsTo('\App\Election');
    }

    public function municipalite()
    {
  		return $this->hasManyThrough(
        '\App\Municipalite',
        '\App\Section',
        'id',
        'id',
        'section_id',
        'municipalite_id'
      );
  	}

    public function parti()
    {
      return $this->belongsTo('\App\Parti');
    }

    public function personne()
    {
      return $this->belongsTo('\App\Personne');
    }

    public function section() {
      return $this->belongsTo('\App\Section');
    }

    public function sectionparticipation() {
      return $this->belongsTo('\App\Sectionparticipation');
    }
}
