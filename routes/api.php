<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Cartes
  Route::apiResource('cartes','CarteController');

//Circonscriptions historiques

  //Relationships
    Route::get('/circos/regions','Circos@xkcd');
    Route::get('/circos/{circo_id}/deputes','Circos@deputes');
    Route::get('/circos/{circo_id}/depute','Circos@dernier_depute');
    Route::get('/circos/{circo_id}/resultats','Circos@resultats');
    Route::get('/circos/{circo_id}/elections','Circos@elections');
    Route::get('/circos/{circo_id}/elections/circonscriptions','Circos@elections_circonscriptions');

    //circonscriptions
    Route::get('/circos/{circo_id}/circonscriptions','Circos@circonscriptions');
    Route::post('/circos/{circo_id}/circonscriptions/add','Circos@addCirconscription');
    Route::delete('/circos/{circo_id}/circonscriptions/{circonscription_id}/remove','Circos@removeCirconscription');

    //circonscriptions
    Route::get('/circos/{circo_id}/tags','Circos@tags');
    Route::post('/circos/{circo_id}/tags','Circos@addTag');
    Route::delete('/circos/{circo_id}/tags/{idTag}','Circos@removeTag');

    Route::apiResource('circos', 'CircoController');

//Circonscriptions légales
  Route::get('/circonscriptions/{circonscription_id}/resultats/elections/{idElection}','Circonscriptions@getThisCircoResultatsThisElection');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats_circo','Circonscriptions@resultats_circo');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats/polygones','Circonscriptions@resultats_circo_polygones');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats_section','Circonscriptions@resultats_section');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats_section/polygones','Circonscriptions@resultats_section_polygones');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats_municipalite','Circonscriptions@resultats_municipalite');
  Route::get('/circonscriptions/{circonscription_id}/elections/{election_id}/resultats/comtes','Circonscriptions@resultats_comte');

  Route::apiResource('circonscriptions', 'CirconscriptionController');

//Circorésultats
  Route::apiResource('circoresultats', 'CircoresultatController');


//Partis
  //CRUD
    Route::post('/partis','Partis@create');
    Route::get('/partis','Partis@index');
    Route::get('/partis/{parti_id}','Partis@show');
    Route::put('/partis/{parti_id}','Partis@update');
    Route::delete('/partis/{parti_id}','Partis@delete');

  //Relationships
    Route::get('/partis/{parti_id}/resultats','Partis@resultats');
    Route::get('/partis/{parti_id}/elections/{election_id}/resultats/sections','Partis@sectionresultats');
    Route::get('/partis/{parti_id}/elections/{election_id}/resultats/municipalites','Partis@resultats_municipalite');
    Route::get('/partis/{parti_id}/elections/{election_id}/resultats/circonscriptions','Partis@circoresultats');

//Elections
  //CRUD
    Route::post('/elections','Elections@create');
    Route::get('/elections','Elections@index');
    Route::get('/elections/{election_id}','Elections@show');
    Route::put('/elections/{election_id}','Elections@update');
    Route::delete('/elections/{election_id}','Elections@delete');

  //Relationships
    Route::get('/elections/{election_id}/resultats','Elections@circoresultats');
    Route::get('/elections/{election_id}/resultats/partis','Elections@resultats_parti');
    Route::get('/elections/{election_id}/resultats/partis/circonscriptions','Elections@agg_circonscriptions');
    Route::get('/elections/{election_id}/resultats/partis/sections','Elections@agg_sections');
    Route::get('/elections/{election_id}/circonscriptions','Elections@circonscriptions');
    Route::get('/elections/{election_id}/resultats/circonscriptions','Elections@circonscriptions_resultats');
    Route::get('/elections/{election_id}/resultats/circonscriptions/polygones','Elections@circonscriptions_resultats_polygones');

//Personnes
  Route::apiResource('personnes', 'PersonneController');

//Régions
  Route::apiResource('regions', 'RegionController');

//Sections
  Route::apiResource('sections', 'SectionController');

//Tags
  Route::apiResource('tags', 'TagController');
