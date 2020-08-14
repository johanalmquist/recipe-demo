<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientCollection;
use App\Http\Resources\IngredientResurce;
use App\Ingredient;
use App\Recipe;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'name' => 'required',
            'measurment_unit' => 'required|exists:measurment_units,id',
            'amount' => 'required'
        ]);
        $ingredient = New Ingredient();
        $ingredient->name = $request->name;
        $ingredient->measurment_unit_id = $request->measurment_unit;
        $ingredient->amount = $request->amount;
        $recipe->ingredient()->save($ingredient);
        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Recipe $recipe
     * @return IngredientCollection
     */
    public function show(Recipe $recipe)
    {
        return new IngredientCollection($recipe->ingredient);
    }

    public function showIngredient(Recipe $recipe, Ingredient $ingredient){
        return new IngredientResurce($ingredient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Recipe $recipe
     * @param \App\Ingredient $ingredient
     * @return IngredientResurce
     */
    public function update(Request $request, Recipe $recipe, Ingredient $ingredient)
    {
        if($request->name){
            $ingredient->name = $request->name;
        }
        if($request->amount){
            $ingredient->amount = $request->amount;
        }
        if($request->amount){
            $ingredient->measurment_unit_id = $request->measurment_unit;
        }
        $recipe->ingredient()->save($ingredient);
        return new IngredientResurce($ingredient);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, Ingredient $ingredient)
    {
        $recipe->ingredient()->delete($ingredient);
        return response(null, 200);
    }
}
