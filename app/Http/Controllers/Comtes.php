<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Comtes extends Controller
{
  // CRUD

    /*
    | Créé une comte
    | POST
    | /api/comtes/create
    */
        public function create(Request $request) {

          $comte = new \App\Comte;

          $comte->nom = $request->nom;
          $comte->code = $request->code;
          $comte->capitale_id = $request->capitale_id;
          $comte->region_id = $request->region_id;

          $comte->save();

          return $comte;
        }

    /*
     | Récupère une collection de toutes les comtes
     | GET
     | /api/comtes
    */
        public function index() {
          return \App\Comte::paginate(20);
        }

    /*
     | Récupère une comte
     | GET
     | /api/comtes/9999
    */
        public function show($comte_id) {
          return \App\Comte::find($comte_id);
        }

    /*
     | Met à jour une comte
     | PUT
     | /api/comtes/9999/update
    */
        public function update($comte_id, Request $request) {

          $comte = \App\Comte::find($comte_id);

          $comte->nom = $request->nom;
          $comte->adoption = $request->adoption;
          $comte->annee = $request->annee;

          $comte->save();

          return \App\Comte::find($comte_id);
        }

    /*
     | Supprime une comte
     | DELETE
     | /api/comtes/9999/delete
    */
        public function delete($comte_id) {
          $comte = \App\Comte::find($comte_id);
          $comte->delete();

          return $comte;
        }

  //Relationships
}
