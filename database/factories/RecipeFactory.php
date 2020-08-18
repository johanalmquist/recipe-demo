<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->userName,
        'slug' => \Illuminate\Support\Str::slug($name),
        'how_to' => $faker->text(800),
        'duration' => $faker->time('H'),
        'desctiption' => $faker->text(300)
    ];
});
