<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MeasurmentUnit;
use Faker\Generator as Faker;

$factory->define(MeasurmentUnit::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'short_name' => $faker->text(5)
    ];
});
