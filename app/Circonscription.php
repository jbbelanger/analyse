<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circonscription extends Model
{
  public function relationables()
  {
    return [
      'carte' => function () {},
      'circos' => function () {},
      'circopolygone' => function () {},
      'circoresultats' => function () {},
      'circoresultats.election' => function () {},
      'circoresultats.parti' => function () {},
      'circoresultats.circoparticipation' => function () {},
      'circoresultats.personne' => function () {},
      'elections' => function () {},
      'region' => function () {},
      'sections' => function () {},
      'sections.municipalite' => function () {},
      'sections.sectionresultats' => function () {},
      'sections.sectionparticipation' => function () {},
      'sections.sectionresultats.election' => function () {},
      'sections.sectionresultats.parti' => function () {},
      'sections.sectionresultats.sectionparticipation' => function () {},
      'sections.sectionresultats.personne' => function () {},
      'sections.sectionpolygone' => function () {},
      'sectionresultats' => function () {},
      'sectionresultats.election' => function () {},
      'sectionresultats.parti' => function () {},
      'sectionresultats.circoparticipation' => function () {},
      'sectionresultats.personne' => function () {}
    ];
  }

  public function carte() {
    return $this->belongsTo('\App\Carte');
  }

  public function circos() {
    return $this->belongsToMany('\App\Circo');
  }

  public function circoparticipations() {
		return $this->hasManyThrough(
      '\App\Circoparticipation',
      '\App\Circoresultat',
      'circonscription_id',
      'id',
      'id',
      'circoparticipation _id'
      // 2 (sur cible) <=> 4 (sur intermédiaire), 1 (sur intermédiaire) <=> 3 (sur origine)
    )->distinct();
	}

  public function circopolygone() {
    return $this->hasOne('\App\Circopolygone');
  }

  public function circoresultats() {
    return $this->hasMany('\App\Circoresultat')->orderBy('bv', 'desc');
  }

  public function elections() {
		return $this->hasManyThrough(
      '\App\Election',
      '\App\Circoresultat',
      'circonscription_id',
      'id',
      'id',
      'election_id'
      // 2 (sur cible) <=> 4 (sur intermédiaire), 1 (sur intermédiaire) <=> 3 (sur origine)
    )->distinct();
	}

  public function region() {
    return $this->belongsTo('\App\Region');
  }

  public function sections() {
    return $this->hasMany('\App\Section');
  }

  public function sectionresultats() {
    return $this->hasMany('\App\Sectionresultat');
  }

  public function resultats_through_section() {
		return $this->hasManyThrough('\App\Sectionresultat','\App\Section');
	}
}
