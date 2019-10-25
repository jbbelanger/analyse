<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circoresultat extends Model
{
    use SoftDeletes;

    /**
     * Scope a query to only results of a single person.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeLaPersonne($query, $id)
    {
        return $query->where('personne_id', $id);
    }

    public function relationables()
    {
      return [
        'circonscription' => function () {},
        'election' => function () {},
        'parti' => function () {},
        'participation' => function () {},
        'personne' => function () {},
      ];
    }

  	public function circonscription()
    {
  		return $this->belongsTo('\App\Circonscription');
  	}

    public function circoparticipation()
    {
  		return $this->belongsTo('\App\Circoparticipation');
    }

  	public function election()
    {
  		return $this->belongsTo('\App\Election');
  	}

  	public function parti()
    {
  		return $this->belongsTo('\App\Parti');
  	}

  	public function personne()
    {
      return $this->belongsTo('\App\Personne');
    }
}
