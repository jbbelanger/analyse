<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Elections extends Controller
{
  // CRUD

    /*
    | Créé une election
    | POST
    | /api/elections/create
    */
        public function create(Request $request) {

          $election = new \App\Election;

          $election->nom = $request->nom;
          $election->type = $request->type;
          $election->date = $request->date;
          $election->legislature_id = $request->legislature_id;

          $election->save();

          return $election;
        }

    /*
     | Récupère une collection de toutes les elections
     | GET
     | /api/elections
    */
        public function index() {
          return \App\Election::all();
        }

    /*
     | Récupère une election
     | GET
     | /api/elections/9999
    */
        public function show($election_id) {
          return \App\Election::find($election_id);
        }

    /*
     | Met à jour une election
     | PUT
     | /api/elections/9999/update
    */
        public function update($election_id, Request $request) {

          $election = \App\Election::find($election_id);

          $election->nom = $request->nom;
          $election->type = $request->type;
          $election->date = $request->date;
          $election->legislature_id = $request->legislature_id;

          $election->save();

          return \App\Election::find($election_id);
        }

    /*
     | Supprime une election
     | DELETE
     | /api/elections/9999/delete
    */
        public function delete($election_id) {
          $election = \App\Election::find($election_id);
          $election->delete();

          return $election;
        }

  //Relationships

    /*
    | Récupère une collection de tous les
    | resultats associées à une election
    | GET
    | /api/elections/9999/resultats
    */

        public function circoresultats($election_id) {
          return \App\Election::with([
            'circoresultats.circonscription',
            'circoresultats.parti',
            'circoresultats.participation',
            'circoresultats.personne'
          ])
            ->find($election_id);
        }

    /*
    | Récupère une collection des résultats d'une élection
    | aggrégés par parti
    | GET
    | /api/elections/9999/circonscriptions
    */

        public function resultats_parti($election_id) {
          $resultats_parti = [
            'resultats' => \DB::select('SELECT
        			pa.id id,
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
        			LEFT JOIN personnes pe ON pe.id = re.personne_id
        			LEFT JOIN partis pa ON pa.id = re.parti_id

        			WHERE
        			re.election_id = '.$election_id.'

        			GROUP BY re.parti_id

        			ORDER BY nb_deputes DESC, bv DESC'),
            'participation' => \DB::select('SELECT
              sum(bv) bv,
              sum(br) br,
              sum(ei) ei

        			FROM
        			participations

              WHERE
        			election_id = '.$election_id)
          ];
          return $resultats_parti;
        }


    /*
    |
    |
    |
    */
      public function agg_circonscriptions($election_id) {
        return \DB::select ("select
        	cast(sum(if(re.bv/pc.bv between 0    and 0.05, 1,0)) as unsigned) 'q1',
        	cast(sum(if(re.bv/pc.bv between 0.05 and 0.1,  1,0)) as unsigned) 'q2',
        	cast(sum(if(re.bv/pc.bv between 0.1  and 0.15, 1,0)) as unsigned) 'q3',
        	cast(sum(if(re.bv/pc.bv between 0.15 and 0.2,  1,0)) as unsigned) 'q4',
        	cast(sum(if(re.bv/pc.bv between 0.2  and 0.25, 1,0)) as unsigned) 'q5',
        	cast(sum(if(re.bv/pc.bv between 0.25 and 0.3,  1,0)) as unsigned) 'q6',
        	cast(sum(if(re.bv/pc.bv between 0.3  and 0.35, 1,0)) as unsigned) 'q7',
        	cast(sum(if(re.bv/pc.bv between 0.35 and 0.4,  1,0)) as unsigned) 'q8',
        	cast(sum(if(re.bv/pc.bv between 0.4  and 0.45, 1,0)) as unsigned) 'q9',
        	cast(sum(if(re.bv/pc.bv between 0.45 and 0.5,  1,0)) as unsigned) 'q10',
        	cast(sum(if(re.bv/pc.bv between 0.5  and 0.55, 1,0)) as unsigned) 'q11',
        	cast(sum(if(re.bv/pc.bv between 0.55 and 0.6,  1,0)) as unsigned) 'q12',
        	cast(sum(if(re.bv/pc.bv between 0.6  and 0.65, 1,0)) as unsigned) 'q13',
        	cast(sum(if(re.bv/pc.bv between 0.65 and 0.7,  1,0)) as unsigned) 'q14',
        	cast(sum(if(re.bv/pc.bv between 0.7  and 0.75, 1,0)) as unsigned) 'q15',
        	cast(sum(if(re.bv/pc.bv between 0.75 and 0.8,  1,0)) as unsigned) 'q16',
        	cast(sum(if(re.bv/pc.bv between 0.8  and 0.85, 1,0)) as unsigned) 'q17',
        	cast(sum(if(re.bv/pc.bv between 0.85 and 0.9,  1,0)) as unsigned) 'q18',
        	cast(sum(if(re.bv/pc.bv between 0.9  and 1,    1,0)) as unsigned) 'q19',
	        pa.*

        from circoresultats re
        left join participations pc on pc.election_id = re.election_id and pc.circonscription_id = re.circonscription_id
        left join partis pa on pa.id = re.parti_id
        where
        	re.election_id = ".$election_id."

        group by re.parti_id");
      }


  /*
  |
  |
  |
  */
    public function agg_sections($election_id) {
      return \DB::select ("select
      	cast(sum(if(rs.bv/ps.bv between 0    and 0.05, 1,0)) as unsigned) 'q1',
      	cast(sum(if(rs.bv/ps.bv between 0.05 and 0.1,  1,0)) as unsigned) 'q2',
      	cast(sum(if(rs.bv/ps.bv between 0.1  and 0.15, 1,0)) as unsigned) 'q3',
      	cast(sum(if(rs.bv/ps.bv between 0.15 and 0.2,  1,0)) as unsigned) 'q4',
      	cast(sum(if(rs.bv/ps.bv between 0.2  and 0.25, 1,0)) as unsigned) 'q5',
      	cast(sum(if(rs.bv/ps.bv between 0.25 and 0.3,  1,0)) as unsigned) 'q6',
      	cast(sum(if(rs.bv/ps.bv between 0.3  and 0.35, 1,0)) as unsigned) 'q7',
      	cast(sum(if(rs.bv/ps.bv between 0.35 and 0.4,  1,0)) as unsigned) 'q8',
      	cast(sum(if(rs.bv/ps.bv between 0.4  and 0.45, 1,0)) as unsigned) 'q9',
      	cast(sum(if(rs.bv/ps.bv between 0.45 and 0.5,  1,0)) as unsigned) 'q10',
      	cast(sum(if(rs.bv/ps.bv between 0.5  and 0.55, 1,0)) as unsigned) 'q11',
      	cast(sum(if(rs.bv/ps.bv between 0.55 and 0.6,  1,0)) as unsigned) 'q12',
      	cast(sum(if(rs.bv/ps.bv between 0.6  and 0.65, 1,0)) as unsigned) 'q13',
      	cast(sum(if(rs.bv/ps.bv between 0.65 and 0.7,  1,0)) as unsigned) 'q14',
      	cast(sum(if(rs.bv/ps.bv between 0.7  and 0.75, 1,0)) as unsigned) 'q15',
      	cast(sum(if(rs.bv/ps.bv between 0.75 and 0.8,  1,0)) as unsigned) 'q16',
      	cast(sum(if(rs.bv/ps.bv between 0.8  and 0.85, 1,0)) as unsigned) 'q17',
      	cast(sum(if(rs.bv/ps.bv between 0.85 and 0.9,  1,0)) as unsigned) 'q18',
      	cast(sum(if(rs.bv/ps.bv between 0.9  and 1,    1,0)) as unsigned) 'q19',
      	pa.*

      from sectionresultats rs
      left join sectionparticipations ps on ps.election_id = rs.election_id and ps.section_id = rs.section_id
      left join partis pa on pa.id = rs.parti_id
      where
      	rs.election_id = ".$election_id."

      group by rs.parti_id");
    }

    /*
    | Récupère une collection de toutes les
    | circonscriptions légales associées à une election
    | GET
    | /api/elections/9999/circonscriptions
    */

        public function circonscriptions($election_id) {
          return \App\Election::with(array(
            'circonscriptions' => function($q) {
              $q->distinct()->get();
              }
          ))
            ->find($election_id);
        }

    /*
    | Récupère une collection de toutes les circonscriptions
    | et leurs résultats légales associées à une election
    | GET
    | /api/elections/9999/circonscriptions
    */

        public function circonscriptions_resultats($election_id) {
          return \App\Election::with(array(
            'circonscriptions' => function($q) {
              $q->distinct()->orderBy('tri_dgeq')->get();
              },
            'circonscriptions.region',
            'circonscriptions.resultats' => function ($q) {
              $q->orderBy('rang');
              },
            'circonscriptions.resultats.personne',
            'circonscriptions.resultats.parti',
            'circonscriptions.resultats.participation',
          ))
            ->find($election_id);
        }

    /*
    | Récupère une collection de toutes les circonscriptions
    | et leurs résultats légales associées à une election
    | GET
    | /api/elections/9999/circonscriptions
    */

        public function circonscriptions_resultats_polygones($election_id) {
          /*return \App\Election::with(array(
            'circonscriptions' => function($q) {
              $q->distinct()->orderBy('tri_dgeq')->paginate(5);
              },
            'circonscriptions.region',
            'circonscriptions.circopolygone',
            'circonscriptions.resultats' => function ($q) {
              $q->orderBy('rang');
              },
            'circonscriptions.resultats.personne',
            'circonscriptions.resultats.parti',
            'circonscriptions.resultats.participation',
          ))
            ->find($election_id);*/
          return \App\Election::find($election_id)
            ->circonscriptions()->with(array(
              'region',
              'circopolygone',
              'resultats' => function ($q) use ($election_id) {
                $q->where('election_id',$election_id)->orderBy('rang');
                },
              'resultats.personne',
              'resultats.parti',
              'resultats.participation',
            ))
              ->distinct()
              ->orderBy('tri_dgeq')
              ->paginate(5);
        }

}
