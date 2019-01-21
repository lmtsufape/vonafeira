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

$factory->define(\projetoGCA\Produto::class, function (Faker $faker) {

    static $increment = 1;

    $produtorId = rand(1, DB::table('produtors')->count());
    $grupoConsumoId = DB::table('produtors')
                        ->where('id', '=', $produtorId)
                        ->first()->grupoconsumo_id;

    $unidadesVendaIds = DB::table('unidade_vendas')
                          ->select('id')
                          ->where('grupoConsumoId', '=', $grupoConsumoId)
                          ->get()->toArray();

    $unidadeVendaId = $unidadesVendaIds[rand(0,count($unidadesVendaIds)-1)]->id;

    return [
        'produtor_id' => $produtorId,
        'grupoconsumo_id' => $grupoConsumoId,
        'preco' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
        'nome' => $faker->word,
        'unidadevenda_id' => $unidadeVendaId
    ];
});
