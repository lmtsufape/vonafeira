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

$factory->define(\projetoGCA\Produtor::class, function (Faker $faker) {

    return [
        'nome' => $faker->name,
        'endereco' => $faker->address,
        'telefone' => '('.$faker->randomNumber($nbDigits = 2).') '. $faker->randomNumber($nbDigits = 5).'-'.
            $faker->randomNumber($nbDigits = 4), 
        'grupoconsumo_id' => rand(1, DB::table('grupo_consumos')->count()),
    ];
});
