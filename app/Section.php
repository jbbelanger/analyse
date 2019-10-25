<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Section extends Model
{
  use SoftDeletes;

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
      parent::boot();

      static::addGlobalScope('bvo', function (Builder $builder) {
          $builder->where([['scrutin_id', 1], ['description', 'not regexp', "5[0-9]{2}"]]);
      });
  }

  public function circonscription()
  {
    return $this->belongsTo('\App\Circonscription');
  }

  public function legislature()
  {
    return $this->belongsTo('\App\Legislature');
  }

  public function municipalite()
  {
    return $this->belongsTo('\App\Municipalite');
  }

  public function sectionparticipation()
  {
		return $this->hasManyThrough(
      '\App\Sectionparticipation',
      '\App\Sectionresultat',
      'section_id',
      'id',
      'id',
      'sectionparticipation_id'
    )->distinct();
	}

  public function sectionpolygone()
  {
    return $this->hasOne('\App\Sectionpolygone');
  }

  /*public function sectionresultats()
  {
    return $this->hasMany('\App\Sectionresultat')->orderBy('circorang', 'asc');
  }*/

  public function sectionresultats()
  {
    return $this->hasMany('\App\Sectionresultat')->groupBy('section_id', 'parti_id')->orderBy('circorang', 'asc');
  }
}
