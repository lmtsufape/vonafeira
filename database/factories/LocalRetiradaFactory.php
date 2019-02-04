<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\projetoGCA\LocalRetirada::class, function (Faker $faker) {

    static $increment = 1;

    return [
        'nome' => $faker->streetAddress,
        'grupoconsumo_id' => $increment++,
    ];
});
