<?php

namespace App\Http\Controllers;

use App\Circoresultat;
use Illuminate\Http\Request;
use App\Http\Resources\Circoresultat as CircoresultatResource;
use App\Http\Resources\CircoresultatCollection;

class CircoresultatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $c = new Circoresultat;
        $circoresultat = Circoresultat::where(function () {});
        $allowed_relations = $c->relationables();
        $relations = [];

        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        if ($request->has('circonscription')) {
          $circoresultat->where('circonscription_id', $request->input('circonscription'));
        }

        if ($request->has('election')) {
          $circoresultat->where('election_id', $request->input('election'));
        }

        if ($request->has('parti')) {
          $circoresultat->where('parti_id', $request->input('parti'));
        }

        if ($request->has('personne')) {
          $circoresultat->where('personne_id', $request->input('personne'));
        }

        return new CircoresultatCollection($circoresultat->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $circoresultat = new Circoresultat;

        $circoresultat->bv = $request->bv;
        $circoresultat->rang = $request->rang;
        $circoresultat->circonscription_id = $request->circonscription_id;
        $circoresultat->election_id = $request->election_id;
        $circoresultat->parti_id = $request->parti_id;
        $circoresultat->participation_id = $request->participation_id;
        $circoresultat->personne_id = $request->personne_id;

        $circoresultat->save();

        return new CircoresultatResource($circoresultat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Circoresultat  $circoresultat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Circoresultat $circoresultat)
    {
        $allowed_relations = $circoresultat->relationables();
        $relations = [];

        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        $circoresultat->load($relations);
        return new CircoresultatResource($circoresultat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circoresultat  $circoresultat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circoresultat $circoresultat)
    {
        $circoresultat->bv = $request->bv;
        $circoresultat->rang = $request->rang;
        $circoresultat->circonscription_id = $request->circonscription_id;
        $circoresultat->election_id = $request->election_id;
        $circoresultat->parti_id = $request->parti_id;
        $circoresultat->participation_id = $request->participation_id;
        $circoresultat->personne_id = $request->personne_id;

        $circoresultat->save();

        return new CircoresultatResource($circoresultat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circoresultat  $circoresultat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circoresultat $circoresultat)
    {
        $circoresultat->delete();

        return new CircoresultatResource($circoresultat);
    }
}
