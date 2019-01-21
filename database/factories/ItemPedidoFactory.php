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

$factory->define(\projetoGCA\ItemPedido::class, function (Faker $faker) {

    static $increment = 1;

    $size = DB::table('pedidos')->count();

    if($increment <= $size){
      $pedidoId = $increment++;
    }else{
      $pedidoId = rand(1, $size);
    }
    
    $pedido = \projetoGCA\Pedido::where('id', '=', $pedidoId)->first();

    $produtosIds = DB::table('produtos')
                          ->select('id')
                          ->where('grupoconsumo_id', '=', $pedido->evento->grupoconsumo_id)
                          ->get()->toArray();

    $produtoId = $produtosIds[rand(0,count($produtosIds)-1)]->id;
    return [
        'pedido_id' => $pedidoId,
        'produto_id' => $produtoId,
        'quantidade' => $faker->randomDigitNotNull
    ];
});
