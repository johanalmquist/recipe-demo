<?php

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Recipe', 100)->create()->each(function ($recipe){
           $recipe->ingredient()->save(factory('App\Ingredient')->make(
               []
           ));
        });
    }
}
