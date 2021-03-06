<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/version', function (){
   return 1.0;
});

Route::apiResource('recipes', 'API\RecipeController');
Route::apiResource('measurment-units', 'API\MeasurmentUnitController');
Route::post('ingredients/recipe/{recipe}', 'API\IngredientController@store');
Route::get('ingredients/recipe/{recipe}', 'API\IngredientController@show');
Route::get('ingredients/recipe/{recipe}/ingredient/{ingredient}', 'API\IngredientController@showIngredient');
Route::patch('ingredients/recipe/{recipe}/ingredient/{ingredient}', 'API\IngredientController@update');
Route::delete('ingredients/recipe/{recipe}/ingredient/{ingredient}', 'API\IngredientController@destroy');
Route::post('recipe/{recipe}/image', 'API\RecipeImageController@store');
Route::get('recipe/{recipe}/image', 'API\RecipeImageController@show');
Route::post('recipe/{recipe}/image/update', 'API\RecipeImageController@update');
Route::delete('recipe/{recipe}/image', 'API\RecipeImageController@destroy');
Route::get('search/{q}', 'API\SearchController@search');
