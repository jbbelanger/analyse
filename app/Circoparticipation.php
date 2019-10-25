<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circoparticipation extends Model
{
  use SoftDeletes;

  public function circonscription()
  {
		return $this->belongsTo('\App\Circonscription');
	}

  public function election()
  {
		return $this->belongsTo('\App\Election');
	}

  public function circoresultats()
  {
		return $this->hasMany('\App\Circoresultat');
	}
}
