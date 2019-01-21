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

$factory->define(\projetoGCA\GrupoConsumo::class, function (Faker $faker) {

    static $userId = 1;

    return [
        'name' => $faker->words($nb = 3, $asText = true),
        'descricao' => $faker->words($nb = 3, $asText = true),
        'periodo' => $faker->randomElement($array = array ('Semanal','Quinzenal','Mensal','Bimestral')),
        'dia_semana' => $faker->dayOfWeek($max = 'now'),
        'prazo_pedidos' => $faker->numberBetween($min = 1, $max = 6),
        'estado' => $faker->state,
        'localidade' => $faker->city,
        'coordenador_id' => $userId++,
    ];
});
