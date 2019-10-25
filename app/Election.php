<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Election extends Model
{

  use SoftDeletes;

  public function carte() {
    return $this->belongsTo('\App\Carte');
  }

  public function circonscriptions() {
		return $this->hasManyThrough(
      '\App\Circonscription',
      '\App\Circoresultat',
      'election_id',
      'id',
      'id',
      'circonscription_id'
    );
	}

  public function circoresultats() {
    return $this->hasMany('\App\Circoresultat');
  }

  public function circoresultatsgroupes() {
    return $this->hasMany('\App\Circoresultatsgroupe')->orderBy('rang');
  }

  public function legislature() {
    return $this->belongsTo('\App\Legislature');
  }

  public function sectionresultats() {
    return $this->hasMany('\App\Sectionresultat');
  }
}
