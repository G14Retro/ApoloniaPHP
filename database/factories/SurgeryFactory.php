<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Surgery;
use Faker\Generator as Faker;

$factory->define(Surgery::class, function (Faker $faker) {
    return [
        'nombre_consultorio' => $faker->numerify('Consultorio ###'),
    ];
});
