<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;
use App\Http\Resources\Region as RegionResource;
use App\Http\Resources\RegionCollection;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $region = Region::where(function () {});
        $allowed_relations = [
          'circos' => function () {},
          //'circos.cartes' => function () {},
          'comtes' => function () {},
          'comtes.municipalites' => function () {},
          'municipalites' => function () {},
        ];
        $relations = [];

        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        return new RegionCollection($region->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $region = new Region;

        $region->code = $request->code;
        $region->nom = $request->nom;

        $region->save();
        return new RegionResource($region);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Region $region)
    {
        $allowed_relations = [
          'circos' => function () {},
          //'circos.cartes' => function () {},
          'comtes' => function () {},
          'comtes.municipalites' => function () {},
          'municipalites' => function () {},
        ];
        $relations = [];

        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        $region->load($relations);
        return new RegionResource($region);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $region->code = $request->code;
        $region->nom = $request->nom;

        $region->save();
        return new RegionResource($region);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return new RegionResource($region);
    }
}
