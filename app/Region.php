<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
  use SoftDeletes;

  public function circonscriptions() {
    return $this->hasMany('\App\Circonscription');
  }

  public function circos() {
    return $this->hasMany('\App\Circo');
  }

  public function comtes() {
    return $this->hasMany('\App\Comte');
  }

  public function municipalites() {
    return $this->hasMany('\App\Municipalite');
  }

}
