<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Personnes extends Controller
{
// CRUD

  /*
  | Créé une personne
  | POST
  | /api/personnes/create
  */
      public function create(Request $request) {

        $personne = new \App\Personne;

        $personne->prenom = $request->prenom;
        $personne->nom = $request->nom;
        $personne->genre = $request->genre;
        $personne->naissance = $request->naissance;
        $personne->deces = $request->deces;
        $personne->lien_assnat = $request->lien_assnat;

        $personne->save();

        return $personne;
      }

  /*
   | Récupère une collection de toutes les personnes
   | GET
   | /api/personnes
  */
      public function index() {
        return \App\Personne::paginate(50);
      }

  /*
   | Récupère une personne
   | GET
   | /api/personnes/9999
  */
      public function show($personne_id) {
        return \App\Personne::find($personne_id);
      }

  /*
   | Met à jour une personne
   | PUT
   | /api/personnes/9999/update
  */
      public function update($personne_id, Request $request) {

        $personne = \App\Personne::find($personne_id);

        $personne->prenom = $request->prenom;
        $personne->nom = $request->nom;
        $personne->genre = $request->genre;
        $personne->naissance = $request->naissance;
        $personne->deces = $request->deces;
        $personne->lien_assnat = $request->lien_assnat;

        $personne->save();

        return \App\Personne::find($personne_id);
      }

  /*
   | Supprime une personne
   | DELETE
   | /api/personnes/9999/delete
  */
      public function delete($personne_id) {
        $personne = \App\Personne::find($personne_id);
        $personne->delete();

        return $personne;
      }

//Relationships

  /*
  | Récupère une collection de tous les résultats
  | associés à une personne
  | GET
  | /api/personnes/9999
  */
      public function resultats_circo($idPersonne) {
        return \App\Personne::with([
          'resultats_circo.circonscription',
          'resultats_circo.participation',
          'resultats_circo.election',
          'resultats_circo.parti'
        ])
          ->find($idPersonne);
      }

  /*
  | Récupère les partis associés à une personne
  | GET
  | /api/personnes/9999
  */
      public function partis($idPersonne) {
        return \App\Personne::with('partis')->find($idPersonne);
      }

  /*
   | Récupère les elections associés à une personne
   | GET
   | /api/personnes/9999
  */
      public function elections($idPersonne) {
        return \App\Personne::with('elections')->find($idPersonne);
      }

  /*
   | Récupère les circonscriptions associés à une personne
   | GET
   | /api/personnes/9999
  */
      public function circonscriptions($idPersonne) {
        return \App\Personne::with(['circonscriptions.circo','circonscriptions.region'])->find($idPersonne);
      }
}
