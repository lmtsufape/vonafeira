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

$factory->define(\projetoGCA\Evento::class, function (Faker $faker) {

    static $grupoConsumoId = 1;

    $grupoConsumo = DB::table('grupo_consumos')
                              ->where('id', '=', $grupoConsumoId)
                              ->first();

    $coordenadorId = $grupoConsumo->coordenador_id;


    $dataInicioPedidos = new DateTime("now");

    $dataEvento = new DateTime("now");
    $dataEvento->add(new DateInterval("P10D"));

    $dataFimPedidos = new DateTime("now");
    $dataFimPedidos->sub(new DateInterval("P{$grupoConsumo->prazo_pedidos}D"));

    return [
        'grupoconsumo_id' => $grupoConsumoId++,
        'coordenador_id' => $coordenadorId,
        'data_inicio_pedidos' => $dataInicioPedidos,
        'data_evento' => $dataEvento,
        'data_fim_pedidos' => $dataFimPedidos,
        'hora_evento' => $faker->time($format = 'H:i:s', $max = 'now'),
        'estaAberto' => True,
    ];
});
