<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeImageController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @param Recipe $recipe
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'image' => 'required'
        ]);
        if($recipe->image){
            $this->removeImage($recipe);
        }
        $file = Storage::disk('digitalocean')->putFile('uploads', $request->image, 'public');
        $recipe->image = $file;
        $recipe->save();
        return response($file, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return $recipe->image;
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
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif'
        ]);
        $oldimage = $recipe->image;
        $newImage =  Storage::disk('digitalocean')->putFile('uploads', $request->image, 'public');
        $recipe->image = $newImage;
        $recipe->save();
        Storage::disk('digitalocean')->delete($oldimage);
        return $newImage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        Storage::disk('digitalocean')->delete($recipe->image);
        $recipe->image = null;
        $recipe->save();
        return response(null, 204);
    }
    protected function removeImage(Recipe $recipe){
        Storage::disk('digitalocean')->delete($recipe->image);
        $recipe->image = null;
        $recipe->save();
    }
}
