<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ingredient;
use Faker\Generator as Faker;

$factory->define(Ingredient::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'amount' => $faker->numberBetween(),
        'measurment_unit_id' => $faker->numberBetween(1,7)
    ];
});
