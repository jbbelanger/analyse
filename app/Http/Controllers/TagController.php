<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\Tag as TagResource;
use App\Http\Resources\TagCollection;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tag = Tag::where(function () {});

        $relations = [];
        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }

        return new TagCollection($tag->with($relations)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag;

        $tag->description = $request->description;
        $tag->parent_id = $request->parent_id;

        $tag->save();
        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Tag $tag)
    {
        $relations = [];
        if ($request->has('relations')) {
          $relations = explode(",", $request->input('relations'));
        }
        $tag->load($relations);

        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $tag->description = $request->description;
        $tag->parent_id = $request->parent_id;

        $tag->save();
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return new TagResource($tag);
    }
}
