<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circopolygone extends Model
{
  public function circonscription() {
    return $this->belongsTo('\App\Circonscription');
  }
}
