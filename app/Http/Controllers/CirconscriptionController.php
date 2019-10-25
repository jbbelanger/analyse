<?php

namespace App\Http\Controllers;

use App\Circonscription;
use Illuminate\Http\Request;
use App\Http\Resources\Circonscription as CirconscriptionResource;
use App\Http\Resources\CirconscriptionCollection;

class CirconscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $c = new Circonscription;
        $circonscription = Circonscription::where(function () {});

        $allowed_relations = $c->relationables();
        $relations = [];
        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        if ($request->has('carte')) {
          $carte = $request->input('carte');
          $circonscription->where('carte_id', $carte);
        }

        if ($request->has('election')) {
          $election = $request->input('election');
          $circonscription->whereHas('circoresultats', function ($q) use ($election) {
            $q->where('election_id',$election);
          });
        }

        $per_page = 20;
        if ($request->has('per_page')) {
          $per_page = $request->input('per_page');
        }

        return new CirconscriptionCollection($circonscription->with($relations)->paginate($per_page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $circonscription = new Circonscription;

      $circonscription->nom = $request->nom;
      $circonscription->carte_id = $request->carte_id;
      $circonscription->region_id = $request->region_id;
      $circonscription->tri_dgeq = $request->tri_dgeq;
      $circonscription->code_dgeq = $request->code_dgeq;
      $circonscription->determinant = $request->determinant;

      $circonscription->save();

      return new CirconscriptionResource($circonscription);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circonscription  $circonscription
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Circonscription $circonscription)
    {
        $allowed_relations = $circonscription->relationables();
        $relations = [];
        if ($request->has('relations')) {
          $request_relations = explode(",", $request->input('relations'));
          $relations = array_intersect_key($allowed_relations,array_flip($request_relations));
        }

        if ($request->has('election')) {
          $election = $request->input('election');

          $circonscription->whereHas('circoresultats', function ($q) use ($election) {
            $q->where('election_id', $election);
          });
          $circonscription->whereHas('sections.sectionresultats', function ($q) use ($election) {
            $q->where('election_id', $election);
          });

          if (isset($relations['circoresultats'])
            || isset($relations['circoresultats.election'])
            || isset($relations['circoresultats.parti'])
            || isset($relations['circoresultats.circoparticipation'])
            || isset($relations['circoresultats.personne'])
          ) {
            $relations['circoresultats'] = function ($q) use ($election) {
              $q->where('election_id', $election);
            };
          }

          if (isset($relations['sectionresultats'])
            || isset($relations['sectionresultats.election'])
            || isset($relations['sectionresultats.parti'])
            || isset($relations['sectionresultats.circoparticipation'])
            || isset($relations['sectionresultats.personne'])
          ) {
            $relations['sectionresultats'] = function ($q) use ($election) {
              $q->where('election_id', $election);
            };
          }

          if (isset($relations['sections'])) {
            $relations['sections'] = function ($q) use ($election) {
              $q->whereHas('sectionresultats', function ($qq) use ($election) {
                $qq->where('election_id', $election);
              });
            };
          }

          if (isset($relations['sections.sectionparticipation'])) {
            $relations['sections.sectionparticipation'] = function ($q) use ($election) {
              $q->where('sectionparticipations.election_id', $election);
            };
          }

          if (isset($relations['sections.sectionresultats'])
            || isset($relations['sections.sectionresultats.election'])
            || isset($relations['sections.sectionresultats.parti'])
            || isset($relations['sections.sectionresultats.sectionparticipation'])
            || isset($relations['sections.sectionresultats.personne'])
          ) {
            $relations['sections.sectionresultats'] = function ($q) use ($election) {
              $q->where('election_id', $election);
            };
          }
        }

        $circonscription->load($relations);

        return new CirconscriptionResource($circonscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circonscription  $circonscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circonscription $circonscription)
    {
        $circonscription->nom = $request->nom;
        $circonscription->carte_id = $request->carte_id;
        $circonscription->region_id = $request->region_id;
        $circonscription->tri_dgeq = $request->tri_dgeq;
        $circonscription->code_dgeq = $request->code_dgeq;
        $circonscription->determinant = $request->determinant;

        $circonscription->save();

        return new CirconscriptionResource($circonscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circonscription  $circonscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circonscription $circonscription)
    {
        $circonscription->delete();
        return new CirconscriptionResource($circonscription);
    }
}
