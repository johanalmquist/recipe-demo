<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeCollection;
use App\Ingredient;
use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RecipeCollection(Recipe::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:recipes',
           'duration' => 'required'
        ]);

        $recipe = new Recipe();
        if($request->how_to){
            $recipe->how_to = $request->how_to;
        }
        if($request->desctiption){
            $recipe->desctiption = $request->desctiption;
        }
        $recipe->name = $request->name;
        $recipe->slug = Str::slug($request->name);
        $recipe->duration = $request->duration;
        $recipe->save();

        return $recipe;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        if(!$recipe){
            return response('not found', 404);
        }
        return $recipe;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        if($request->name){
            $recipe->name = $request->name;
            $recipe->slug = Str::slug($request->name);
        }
        if($request->how_to){
            $recipe->how_to = $request->how_to;
        }
        if($request->newHowTo){
            $recipe->how_to = $request->newHowTo;
        }
        if($request->desctiption){
            $recipe->desctiption = $request->desctiption;
        }
        if($request->duration){
            $recipe->duration = $request->duration;
        }
        $recipe->save();

        return $recipe;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->ingredient()->delete();
        $recipe->delete();
        return response(null, 204);
    }
}
