<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
  protected $table = 'cartes';
  public $timestamps = false;

  public function circonscriptions() {
    return $this->hasMany('\App\Circonscription');
  }

  public function elections() {
    return $this->hasMany('\App\Election');
  }
}
