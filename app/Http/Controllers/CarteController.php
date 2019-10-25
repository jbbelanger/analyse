<?php

namespace App\Http\Controllers;

use App\Carte;
use Illuminate\Http\Request;
use App\Http\Resources\Carte as CarteResource;
use App\Http\Resources\CarteCollection;

class CarteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carte = Carte::where(function () {});

        $relations = [];

        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }

        return new CarteCollection($carte->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carte = new Carte;

        $carte->nom = $request->nom;
        $carte->adoption = $request->adoption;
        $carte->annee = $request->annee;

        $carte->save();

        return new CarteResource($carte);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Carte $carte)
    {
        $relations = [];
        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }
        $carte->load($relations);

        return new CarteResource($carte);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carte $carte)
    {
        $carte->nom = $request->nom;
        $carte->adoption = $request->adoption;
        $carte->annee = $request->annee;

        $carte->save();

        return new TagResource($carte);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carte  $carte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carte $carte)
    {
        $carte->delete();
        return new TagResource($carte);
    }
}
