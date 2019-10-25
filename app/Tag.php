<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
  use SoftDeletes;
  protected $table = 'tags';

  public function circos() {
		return $this->belongsToMany('\App\Circo');
	}

  public function parent() {
		return $this->belongsTo('\App\Tag','parent_id');
	}

  public function children() {
		return $this->hasMany('\App\Tag','parent_id');
	}
}
