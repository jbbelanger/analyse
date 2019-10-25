<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Circonscriptions extends Controller
{
//Relationships

    /*
     | Récupère une collection de tous les resultats par section de vote
     | associés à une circonscription légale et une élection
     | GET
     | /api/circonscriptions/9999/elections/8888/resultats
    */
        public function resultats_section($circonscription_id,$election_id) {
          $legislature = \App\Election::find($election_id)->legislature()->pluck('id')->first();
          $response = [
            'circonscription' => \App\Circonscription::find($circonscription_id),
            'election' => \App\Election::find($election_id),
            'resultats' => \App\Section::with(array(
              'municipalite',
              'sectionresultats' => function($q) {
                $q->join('sectionparticipations', function($j) {
                    $j->on('sectionparticipations.election_id', '=',  'sectionresultats.election_id');
                    $j->on('sectionparticipations.section_id', '=',  'sectionresultats.section_id');
                  })
                  ->groupBy('sectionresultats.section_id','sectionresultats.parti_id')
                  ->selectRaw('sectionresultats.section_id, sectionresultats.municipalite_id, sectionresultats.circonscription_id, sectionresultats.election_id, sectionresultats.parti_id, sectionresultats.personne_id, cast(sum(sectionresultats.bv) as unsigned) bv, sectionresultats.circorang, cast(sum(sectionparticipations.bv) as unsigned)  ps_bv, cast(sum(sectionparticipations.br) as unsigned)  ps_br, cast(sum(sectionparticipations.ei) as unsigned) ps_ei')
                  ->orderBy('sectionresultats.circorang','asc')
                  ->get();
                },
              'sectionresultats.parti',
              'sectionresultats.personne',
            ))
              ->where('circonscription_id',$circonscription_id)
              ->where('legislature_id',$legislature)
              ->where('scrutin_id',1)
              ->orderBy('unique_id','asc')
              ->get()
          ];

          return $response;
        }

      /*
       | Récupère une collection de tous les resultats par section de vote
       | associés à une circonscription légale et une élection avec les polygones
       | GET
       | /api/circonscriptions/9999/elections/8888/resultats/sv
      */
          public function resultats_section_polygones($circonscription_id,$election_id) {
            $legislature = \App\Election::find($election_id)->legislature()->pluck('id')->first();
            $response = [
              'circonscription' => \App\Circonscription::find($circonscription_id),
              'election' => \App\Election::find($election_id),
              'resultats' => \App\Section::with(array(
                'sectionpolygone',
                'municipalite',
                'sectionresultats',
                'sectionresultats.parti',
                'sectionresultats.personne',
              ))
                ->where('circonscription_id',$circonscription_id)
                ->where('legislature_id',$legislature)
                ->where('scrutin_id',1)
                ->orderBy('unique_id','asc')
                ->paginate(5)
            ];

            return $response;
          }

    /*
     | Récupère une collection de tous les resultats par municipalité
     | associés à une circonscription légale et une élection
     | GET
     | /api/circonscriptions/9999/elections/8888/resultats
    */
          public function resultats_municipalite($circonscription_id,$election_id) {
            $legislature = \App\Election::find($election_id)->legislature;
            $municipalites = \App\Sectionresultat::join('sections','sections.id','=','sectionresultats.section_id')
              ->where([
                ['sectionresultats.election_id',$election_id],
                ['sectionresultats.circonscription_id',$circonscription_id],
                ['sectionresultats.scrutin_id',1]
              ])
              ->distinct()
              ->pluck('sections.municipalite_id');
            $response = [
              'circonscription' => \App\Circonscription::find($circonscription_id),
              'election' => \App\Election::find($election_id),
              'resultats' => \App\Municipalite::with(array(
                'sectionresultats' => function($q) use ($circonscription_id) {
                  $q
                    ->join('sectionparticipations', 'sectionparticipations.id', '=', 'sectionresultats.sectionparticipation_id')
                    ->join('sections', 'sections.id', '=', 'sectionresultats.section_id')
                    ->where('sections.circonscription_id',$circonscription_id)
                    ->groupBy('sections.municipalite_id','sectionresultats.parti_id')
                    ->selectRaw('sections.municipalite_id, sections.circonscription_id, sectionresultats.election_id, sectionresultats.parti_id, sectionresultats.personne_id, cast(sum(sectionresultats.bv) as unsigned) bv, sectionresultats.circorang, cast(sum(sectionparticipations.bv) as unsigned)  ps_bv, cast(sum(sectionparticipations.br) as unsigned)  ps_br, cast(sum(sectionparticipations.ei) as unsigned) ps_ei')
                    ->orderBy('circorang','asc')
                    ->get();
                  },
                'sectionresultats.parti',
                'sectionresultats.personne',
              ))
                ->whereIn('id',$municipalites)
                ->get()
            ];

            return $response;
          }

    /*
     | Récupère une collection de tous les resultats par municipalité
     | associés à une circonscription légale et une élection
     | GET
     | /api/circonscriptions/9999/elections/8888/resultats
    */
          public function resultats_comte($circonscription_id,$election_id) {
            $legislature = \App\Election::find($election_id)->legislature;
            $comtes = \App\Sectionresultat::join('sections','sections.id','=','sectionresultats.section_id')
              ->join('municipalites','municipalites.id','=','sections.municipalite_id')
              ->where([
                ['sectionresultats.election_id',$election_id],
                ['sectionresultats.circonscription_id',$circonscription_id],
                ['sectionresultats.scrutin_id',1]
              ])
              ->distinct()
              ->pluck('municipalites.comte_id');
            $response = [
              'circonscription' => \App\Circonscription::find($circonscription_id),
              'election' => \App\Election::find($election_id),
              'resultats' => \App\Comte::with(array(
                'sectionresultats' => function($q) use ($circonscription_id) {
                  $q
                    ->join('sectionparticipations', 'sectionparticipations.id', '=', 'sectionresultats.sectionparticipation_id')
                    ->join('sections', 'sections.id', '=', 'sectionresultats.section_id')
                    ->join('municipalites','municipalites.id','=','sections.municipalite_id')
                    ->where('sections.circonscription_id',$circonscription_id)
                    ->groupBy('municipalites.comte_id','sectionresultats.parti_id')
                    ->selectRaw('municipalites.comte_id, sections.circonscription_id, sectionresultats.election_id, sectionresultats.parti_id, sectionresultats.personne_id, cast(sum(sectionresultats.bv) as unsigned) bv, sectionresultats.circorang, cast(sum(sectionparticipations.bv) as unsigned)  ps_bv, cast(sum(sectionparticipations.br) as unsigned)  ps_br, cast(sum(sectionparticipations.ei) as unsigned) ps_ei')
                    ->orderBy('circorang','asc')
                    ->get();
                  },
                'sectionresultats.parti',
                'sectionresultats.personne',
              ))
                ->whereIn('comtes.id',$comtes)
                ->get()
            ];

            return $response;
          }
}
