<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Circos extends Controller
{
// CRUD

    /*
    | Créé une circonsription historique
    | POST
    | /api/circos/create
    */
        public function create(Request $request) {

          $circo = new \App\Circo;

          $circo->nom = $request->nom;
          $circo->determinant = $request->determinant;
          $circo->region_id = $request->region_id;

          $circo->save();

          return $circo;
        }

    /*
     | Récupère une collection de toutes les circonscriptions historiques
     | GET
     | /api/circos
    */
        public function index() {
          return \App\Circo::with('region')->get();
        }

    /*
     | Récupère une circonscription historique
     | GET
     | /api/circos/9999
    */
        public function show($circo_id) {
          return \App\Circo::with('region')->find($circo_id);;
        }

    /*
     | Met à jour une circonscription historique
     | PUT
     | /api/circos/9999/update
    */
        public function update($circo_id, Request $request) {

          $circo = \App\Circo::find($circo_id);

          $circo->nom = $request->nom;
          $circo->determinant = $request->determinant;
          $circo->region_id = $request->region_id;

          $circo->save();

          return \App\Circo::find($circo_id);
        }

    /*
     | Supprime une circonscription historique
     | DELETE
     | /api/circos/9999/delete
    */
        public function delete($circo_id) {
          $circo = \App\Circo::find($circo_id);
          $circo->delete();

          return $circo;
        }

//Relationships

    /*
    | Récupère une collection de toutes les circonscriptions historiques
    | avec leur région
    | GET
    | /api/circos
    */
        public function xkcd() {
          return \App\Circo::with('region')->get();
        }

    /*
    | Récupère une collection de tous les députés
    | associés à une circonscription historique
    | GET
    | /api/circonscriptions/9999/deputes
    */
        public function deputes($circo_id) {
          return \App\Circo::with(array(
            'resultats' => function($q) {
              $q->join('elections','elections.id','=','circoresultats.election_id')
                ->where('rang',1)
                ->orderBy('elections.date','desc');
            },
            'resultats.personne',
            'resultats.parti',
            'resultats.election'
          ))->find($circo_id);
        }

    /*
    | Récupère une collection du dernier député
    | associé à une circonscription historique
    | GET
    | /api/circonscriptions/9999/deputes
    */
        public function dernier_depute($circo_id) {
          return \App\Circo::find($circo_id)
          ->circonscriptions()
            ->where('carte_id',4)
            ->first()
          ->resultats()
            ->with(['personne','parti'])
            ->join('elections','elections.id','=','circoresultats.election_id')
            ->where('rang',1)
            ->orderBy('elections.date','desc')
            ->first();
        }

    /*
     | Récupère une collection de tous les résultats des
     | circonscriptions légales associées à une circonscription historique
     | GET
     | /api/circonscriptions/9999/resultats
    */
        public function resultats($circo_id) {
          $circo = \App\Circo::with('region')->find($circo_id);
          $elections = \DB::select('SELECT
            el.id election_id

            FROM circos co
            LEFT JOIN circo_circonscription cc ON cc.circo_id = co.id
            LEFT JOIN circonscriptions ci ON ci.id = cc.circonscription_id
            LEFT JOIN circoresultats re ON re.circonscription_id = ci.id
            LEFT JOIN elections el ON el.id = re.election_id

            WHERE co.id = '.$circo_id.'

            GROUP BY el.id
            ORDER BY el.date DESC
          ');
          $circo_elections = [];

          foreach ($elections as $election) {
            $election_circonscriptions = \App\Election::find($election->election_id);
            array_push($circo_elections,$election_circonscriptions);
          }
          return $circo_elections;
        }


    /*
     | Récupère une collection de tous les députés
     | associés à une circonscription historique
     | GET
     | /api/circonscriptions/9999/elections
    */
        public function elections($circo_id) {
          return \DB::select('SELECT
            el.*

            FROM circos co
            LEFT JOIN circo_circonscription cc ON cc.circo_id = co.id
            LEFT JOIN circonscriptions ci ON ci.id = cc.circonscription_id
            LEFT JOIN circoresultats re ON re.circonscription_id = ci.id
            LEFT JOIN elections el ON el.id = re.election_id

            WHERE co.id = '.$circo_id.'

            GROUP BY el.id
            ORDER BY el.date DESC
          ');
          $circo_elections = [];
        }

    /*
     | Récupère une collection de tous les députés
     | associés à une circonscription historique
     | GET
     | /api/circonscriptions/9999/elections/circonscriptions
    */
        public function elections_circonscriptions($circo_id) {
          $circo = \App\Circo::with('region')->find($circo_id);
          $elections = \DB::select('SELECT
            el.id election_id,
            group_concat(distinct ci.id order by ci.nom) circonscription_id

            FROM circos co
            LEFT JOIN circo_circonscription cc ON cc.circo_id = co.id
            LEFT JOIN circonscriptions ci ON ci.id = cc.circonscription_id
            LEFT JOIN circoresultats re ON re.circonscription_id = ci.id
            LEFT JOIN elections el ON el.id = re.election_id

            WHERE co.id = '.$circo_id.'

            GROUP BY el.id
            ORDER BY el.date DESC
          ');
          $circo_elections = [];

          foreach ($elections as $election) {
            $circos_id = explode(',',$election->circonscription_id);
            $election_circonscriptions = \App\Election::with(array(
              'circonscriptions' => function($q) use ($circos_id) {
                $q->whereIn('circonscriptions.id',$circos_id)->distinct()->get();
                }
            ))->find($election->election_id);
            array_push($circo_elections,$election_circonscriptions);
          }
          return [
            'circo' => $circo,
            'elections' => $circo_elections
          ];
        }

/**********************************Circonscriptions****************************/
    /*
     | Récupère une collection de toutes les circonscriptions légales
     | associées à une circonscription historique
     | GET
     | /api/circos/9999/circonscriptions
    */
        public function circonscriptions($circo_id) {
          return \App\Circo::with([
            'region',
            'circonscriptions.carte',
            'circonscriptions.region'
            ])
              ->find($circo_id);
        }

    /*
     | Associe une circonscription légale à une circonscription historique
     | POST
     | /api/circos/9999/circonscriptions/add
    */
        public function addCirconscription(Request $request) {

          $circo = \App\Circo::find($request->circo_id);
          $circonscription = \App\Circonscription::find($request->circonscription_id);
          $circo->circonscriptions()->attach($request->circonscription_id);

          return [
            'ok' => true,
            'circo' => $circo,
            'circonscription' => $circonscription
          ];
        }

    /*
     | Dissocie une circonscription légale d'une circonscription historique
     | DELETE
     | /api/circos/9999/circonscriptions
    */
        public function removeCirconscription($circo_id,$circonscription_id) {

          $circo = \App\Circo::find($circo_id);
          $circonscription = \App\Circonscription::find($circonscription_id);
          $circo->circonscriptions()->detach($circonscription_id);

          return [
            'ok' => true,
            'circo' => $circo,
            'circonscription' => $circonscription
          ];
        }

/**********************************Tags****************************************/
    /*
     | Récupère une collection de tous les tags
     | associés à une circonscription historique
     | GET
     | /api/circos/9999/tags
    */
        public function tags($circo_id) {
          return \App\Circo::with('tags')->find($circo_id);
        }

    /*
     | Associe un tag à une circonscription historique
     | POST
     | /api/circos/9999/tags/add
    */
        public function addTag(Request $request) {

          $circo = \App\Circo::find($request->circo_id);
          $tag = \App\Tag::find($request->tag_id);
          $circo->tags()->attach($request->tag_id);

          return [
            'ok' => true,
            'circo' => $circo,
            'tag' => $tag
          ];
        }

    /*
     | Dissocie un tag d'une circonscription historique
     | DELETE
     | /api/circos/9999/tags/remove
    */
        public function removeTag($circo_idHisto,$idTag) {

          $circo = \App\Circo::find($circo_idHisto);
          $tag = \App\Tag::find($idTag);
          $circo->tags()->detach($idTag);
          return [
            'ok' => true,
            'circo' => $circo,
            'tag' => $tag
          ];
        }

}
