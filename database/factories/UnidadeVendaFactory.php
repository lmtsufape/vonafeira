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

$factory->define(\projetoGCA\UnidadeVenda::class, function (Faker $faker) {

    return [
        'nome' => $faker->word,
        'descricao' => $faker->word,
        'is_fracionado' => $faker->boolean,
        'is_porcao' => $faker->boolean,
    ];
});
