<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipesIngredientsCollection;
use App\Ingredient;
use App\MeasurmentQty;
use App\MeasurmentUnit;
use App\Recipe;
use App\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeIngredientController extends Controller
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
            'ingredient' => 'required',
            'measurment_qty' => 'required',
            'measurment_unit' => 'required'
        ]);
        //Check if ingrients exist. If not create it
        if(!Ingredient::where('id', $request->ingredient)->first()){
            $ingredient = Ingredient::create(['name' => $request->ingredient]);
            $ingredient = $ingredient->id;
        } else {
            $ingredient = $request->ingredient;
        }


        //Check if MeasurmentQty exiat. If not create it
        if(!MeasurmentQty::where('id', $request->measurment_qty)->first()){
            $measurment_qty = MeasurmentQty::create(['qty_amount' => $request->measurment_qty]);
            $measurment_qty = $measurment_qty->id;
        } else {
            $measurment_qty = $request->measurment_qty;
        }
        //Check if MeasurmentUnit exsit. If not creatie it
        if(!MeasurmentUnit::where('id' , $request->measurment_unit)->first()){
            $measurment_unit = MeasurmentUnit::create(['name' => $request->measurment_unit]);
            $measurment_unit = $measurment_unit->id;
        } else {
            $measurment_unit = $request->measurment_unit;
        }

        $ri = new RecipeIngredient();
        $ri->recipe_id = $recipe->id;
        $ri->ingredient_id = $ingredient;
        $ri->measurment_qty_id = $measurment_qty;
        $ri->measurment_unit_id = $measurment_unit;
        $ri->save();
        return response(null, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        $r = RecipeIngredient::where('recipe_id', $recipe->id)->with('ingredient', 'measurmentQty', 'measurmentUnit')->get();
        dd($r);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
