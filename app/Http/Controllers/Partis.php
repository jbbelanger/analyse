<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Partis extends Controller
{
// CRUD

  /*
  | Créé un parti
  | POST
  | /api/circos/create
  */
      public function create(Request $request) {

        $parti = new \App\Parti;

        $parti->nom_officiel = $request->nom_officiel;
        $parti->nom_usuel = $request->nom_usuel;
        $parti->abb_usuelle = $request->abb_usuelle;
        $parti->abb_officielle = $request->abb_officielle;
        $parti->couleur = $request->couleur;
        $parti->rgb = $request->rgb;
        $parti->rgb = $request->determinant;

        $parti->save();

        return $parti;
      }

  /*
   | Récupère une collection de tous les partis
   | GET
   | /api/circos
  */
      public function index() {
        return \App\Parti::orderBy('nom_usuel')->get();
      }

  /*
   | Récupère une parti
   | GET
   | /api/circos/9999
  */
      public function show($parti_id) {
        return \App\Parti::find($parti_id);
      }

  /*
   | Met à jour un parti
   | PUT
   | /api/circos/9999/update
  */
      public function update($parti_id, Request $request) {

        $parti = \App\Parti::find($parti_id);

        $parti->nom_officiel = $request->nom_officiel;
        $parti->nom_usuel = $request->nom_usuel;
        $parti->abb_usuelle = $request->abb_usuelle;
        $parti->abb_officielle = $request->abb_officielle;
        $parti->couleur = $request->couleur;
        $parti->rgb = $request->rgb;
        $parti->rgb = $request->determinant;

        $parti->save();

        return \App\Parti::find($parti_id);
      }

  /*
   | Supprime un parti
   | DELETE
   | /api/circos/9999/delete
  */
      public function delete($parti_id) {
        $parti = \App\Parti::find($parti_id);
        $parti->delete();

        return $parti;
      }

//Relationships

    /*
     | Résultats d'un parti pour toutes les élections auxquelles il participé
     | GET
     | /api/partis
    */
        public function resultats($idParti)
      	{
      		$resultats = \DB::select('SELECT
      			el.id elec_id,
      			el.nom elec_nom,
      			el.type elec_type,
      			el.date elec_date,
      			pa.id parti_id,
      			pa.abb_usuelle abb,
      			pa.nom_usuel nom,
      			pa.couleur couleur,
      			sum(re.bv) bv,
      			sum(re.bv)/(SELECT sum(bv) FROM participations WHERE election_id = re.election_id) pc_bv,
      			count(re.parti_id) nb_candidats,
      			sum(if(re.rang=1,1,null)) nb_deputes

      			FROM
      			circoresultats re
      			LEFT JOIN circonscriptions ci ON ci.id = re.circonscription_id
      			LEFT JOIN partis pe ON pe.id = re.parti_id
      			LEFT JOIN partis pa ON pa.id = re.parti_id
      			LEFT JOIN elections el on el.id = re.election_id

      			WHERE
      			re.parti_id = '.$idParti.'

      			GROUP BY re.parti_id, re.election_id

      			ORDER BY el.date DESC');
      		$parti = \App\Parti::find($idParti);
      		return [
      			'id' => $parti->id,
      			'nom_usuel' => $parti->nom_usuel,
      			'nom_officiel' => $parti->nom_officiel,
      			'abb_usuelle' => $parti->abb_usuelle,
      			'abb_officielle' => $parti->abb_officielle,
      			'determinant' => $parti->determinant,
      			'resultats' => $resultats
      		];
      	}

    /*
     | Résultats par section de vote pour un parti
     | lors d'une élection
     | GET
     | /api/partis/9999/elections/8888/resultats/sections
    */
        public function sectionresultats($parti_id,$election_id) {
          return \App\Parti::find($parti_id)
            ->sectionresultats()
            ->join('sectionparticipations', function($j) {
              $j->on('sectionparticipations.election_id', '=',  'sectionresultats.election_id');
              $j->on('sectionparticipations.section_id', '=',  'sectionresultats.section_id');
            })
            ->groupBy('sectionresultats.section_id','sectionresultats.parti_id')
            ->selectRaw('sectionresultats.id, sectionresultats.section_id, sectionresultats.personne_id, cast(sum(sectionresultats.bv) as unsigned) bv, sum(sectionresultats.bv)/sum(sectionparticipations.bv) pc_bv, cast(sum(sectionparticipations.bv) as unsigned) ps_bv, cast(sum(sectionparticipations.br) as unsigned) ps_br, cast(sum(sectionparticipations.ei) as unsigned) ps_ei, sectionresultats.circorang')
            ->where([
              ['sectionresultats.election_id',$election_id],
              ['sectionresultats.scrutin_id',1]
            ])
            ->with(array(
              'personne',
              'section.municipalite',
              'section.circonscription',
              'section.sectionresultats' => function ($q) {
                $q->orderBy('bv','desc');
                },
              'section.sectionresultats.parti'
            ))
            ->orderBy('pc_bv','desc')
            ->paginate(100);
        }

    /*
     | Résultats par municipalite pour un parti
     | lors d'une élection
     | GET
     | /api/partis/9999/elections/8888/resultats/sections
    */
        public function resultats_municipalite($parti_id,$election_id) {
          return \App\Parti::find($parti_id)
            ->sectionresultats()
            ->join('sections','sections.id','=','sectionresultats.section_id')
            ->join('sectionparticipations', function($j) {
              $j->on('sectionparticipations.election_id', '=',  'sectionresultats.election_id');
              $j->on('sectionparticipations.section_id', '=',  'sectionresultats.section_id');
            })
            ->groupBy('sections.municipalite_id','sectionresultats.parti_id')
            ->selectRaw('sectionresultats.id, sections.municipalite_id, sectionresultats.personne_id, cast(sum(sectionresultats.bv) as unsigned) bv, sum(sectionresultats.bv)/sum(sectionparticipations.bv) pc_bv, cast(sum(sectionparticipations.bv) as unsigned) ps_bv, cast(sum(sectionparticipations.br) as unsigned) ps_br, cast(sum(sectionparticipations.ei) as unsigned) ps_ei, sectionresultats.circorang')
            ->where([
              ['sectionresultats.election_id',$election_id],
              ['sectionresultats.scrutin_id',1]
            ])
            ->with(array(
              'personne',
              'municipalite' => function ($q) {
                $q->first();
                }
            ))
            ->orderBy('pc_bv','desc')
            ->paginate(100);
        }

    /*
     | Résultats par circonscriptions pour un parti
     | lors d'une élection
     | GET
     | /api/partis/
    */
        public function circoresultats($parti_id,$election_id) {
          return \App\Parti::find($parti_id)
            ->circoresultats()
            ->join('circoparticipations','circoparticipations.id','=','circoresultats.circoparticipation_id')
            ->selectRaw('circoresultats.id, circoresultats.personne_id, circoresultats.circonscription_id, circoresultats.circoparticipation_id, circoresultats.bv, circoresultats.bv/circoparticipations.bv pc_bv, circoresultats.rang')
            ->where('circoresultats.election_id',$election_id)
            ->with(array(
              'circoparticipation',
              'personne',
              'circonscription',
              'circonscription.circoresultats' => function ($q) use ($election_id) {
                $q->where('election_id',$election_id)->orderBy('bv','desc')->get();
                },
              'circonscription.circoresultats.parti'
            ))
            ->orderBy('pc_bv','desc')
            ->paginate(125);
        }
}
