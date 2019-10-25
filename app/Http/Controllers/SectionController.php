<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Resources\Section as SectionResource;
use App\Http\Resources\SectionCollection;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $section = Section::where(function () {});

        $relations = [];
        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }

        return new SectionCollection($section->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $section = new Section;

        $section->description = $request->description;
        $section->circonscription_id = $request->circonscription_id;
        $section->legislature_id = $request->legislature_id;
        $section->municipalite_id = $request->municipalite_id;
        $section->regr_bva = $request->regr_bva;
        $section->scrutin_id = $request->scrutin_id;
        $section->unique_id = $request->unique_id;

        $section->save();
        return new SectionResource($section);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Section $section)
    {
        $relations = [];
        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }
        $section->load($relations);

        return new SectionResource($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $section->description = $request->description;
        $section->circonscription_id = $request->circonscription_id;
        $section->legislature_id = $request->legislature_id;
        $section->municipalite_id = $request->municipalite_id;
        $section->regr_bva = $request->regr_bva;
        $section->scrutin_id = $request->scrutin_id;
        $section->unique_id = $request->unique_id;

        $section->save();
        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return new SectionResource($section);
    }
}
