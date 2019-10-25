<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circoresultatsgroupe extends Model
{
    public function circonscription()
    {
  		return $this->belongsTo('\App\Circonscription');
  	}

  	public function election()
    {
  		return $this->belongsTo('\App\Election');
  	}

  	public function parti()
    {
  		return $this->belongsTo('\App\Parti');
  	}

  	public function personne()
    {
      return $this->belongsTo('\App\Personne');
    }
}
