<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipationPivot extends Model
{
  protected $table = 'resultat_participations';
  public $timestamps = false;

  public function participation() {
    return $this->hasOne('\App\Participation','participations_id');
  }

  public function resultat() {
    return $this->hasOne('\App\Circoresultat','resultats_id');
  }
}
