<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectionparticipation extends Model
{
    public function circonscription()
    {
      return $this->belongsTo('\App\Circonscription');
    }

    public function election()
    {
      return $this->belongsTo('\App\Election');
    }

    public function section()
    {
      return $this->belongsTo('\App\Section');
    }

    public function sectionresultats()
    {
      return $this->hasMany('\App\Sectionresultat');
    }
}
