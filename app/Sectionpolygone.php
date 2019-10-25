<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectionpolygone extends Model
{
  public function section()
  {
    return $this->belongsTo('\App\Section');
  }
}
