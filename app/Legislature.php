<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legislature extends Model
{
    public function elections()
    {
      return $this->hasMany('App\Election');
    }
}
