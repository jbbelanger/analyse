<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CircoPivot extends Model
{
  use SoftDeletes;
  protected $table = 'circo_circonscription';
 	public $timestamps = false;

  public function circonscription() {
    return $this->hasOne('\App\Circonscription');
  }

  public function circo() {
    return $this->hasOne('\App\Circo');
  }

}
