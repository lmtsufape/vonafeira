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

$factory->define(\projetoGCA\Endereco::class, function (Faker $faker) {

    static $usuarioId = 1;

    return [
        'rua' => $faker->name,
        'numero' => rand(1,100),
        'bairro' => $faker->name,
        'cidade' => $faker->city(),
        'uf' => $faker->randomElement($array = array ('AC', 'AL', 'AP', 'AM','BA','CE')),
        'cep' => $faker->randomNumber($nbDigits = 8),
        'user_id' => $usuarioId++,
    ];

});
