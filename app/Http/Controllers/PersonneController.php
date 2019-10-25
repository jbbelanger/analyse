<?php

namespace App\Http\Controllers;

use App\Personne;
use Illuminate\Http\Request;
use App\Http\Resources\Personne as PersonneResource;
use App\Http\Resources\PersonneCollection;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = new Personne;
        $personne = Personne::where(function () {});
        $allowed_relations = $p->relationables();
        $relations = [];
        
        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        return new PersonneCollection($personne->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personne  $personne
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Personne $personne)
    {
        $allowed_relations = [
          'circonscriptions' => function () {},
          'circonscriptions.region' => function () {},
          'elections' => function () {},
          'partis' => function () {},
          'resultats' => function () {},
        ];
        $relations = [];

        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        $personne->load($relations);
        return new PersonneResource($personne);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Personne  $personne
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personne $personne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Personne  $personne
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personne $personne)
    {
        //
    }
}
