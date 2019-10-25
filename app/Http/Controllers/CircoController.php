<?php

namespace App\Http\Controllers;

use App\Circo;
use Illuminate\Http\Request;
use App\Http\Resources\Circo as CircoResource;
use App\Http\Resources\CircoCollection;

class CircoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $c = new Circo;
        $circo = Circo::where(function () {});

        $allowed_relations = $c->relationables();
        $relations = [];
        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        if ($request->has('carte')) {
          $carte = $request->input('carte');
          $circo->whereHas('circonscriptions', function ($q) use ($carte) {
            $q->where('carte_id', $carte);
          });
          if (isset($relations['circonscriptions'])) {
            $relations['circonscriptions'] = function ($q) use ($carte) {
              $q->where('carte_id', $carte);
            };
          }
        }

        $relations;
        $per_page = 20;
        if ($request->has('per_page')) {
          $per_page = $request->input('per_page');
        }

        return new CircoCollection($circo->with($relations)->paginate($per_page));
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
     * @param  \App\Circo  $circo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Circo $circo)
    {

        $allowed_relations = $circo->relationables();
        $relations = [];
        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        if ($request->has('carte')) {
          $carte = $request->input('carte');
          $circo->whereHas('circonscriptions', function ($q) use ($carte) {
            $q->where('carte_id',$carte);
          });
        }

        if (isset($relations['elections.circoresultatsgroupes'])
         || isset($relations['elections.circoresultatsgroupes.parti'])
        ) {
          $relations['elections.circoresultatsgroupes'] = function ($q) use ($circo) {
            $q->where('circo_id', $circo->id);
          };
        }

        if (isset($relations['elections.circonscriptions'])) {
          $relations['elections.circonscriptions'] = function ($q) use ($circo) {
            $q->whereHas('circos', function ($qq) use ($circo) {
              $qq->where('circos.id', $circo->id);
            })->distinct();
          };
        }

        $circo->load($relations);
        return new CircoResource($circo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circo  $circo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circo $circo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circo  $circo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circo $circo)
    {
        //
    }
}
