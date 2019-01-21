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

$factory->define(\projetoGCA\Consumidor::class, function (Faker $faker) {

    static $userId = 1;

    $grupoId = 0;

    $grupoConsumo = DB::table('grupo_consumos')
                              ->where('coordenador_id', '=', $userId)
                              ->first();
                              
    if(!is_null($grupoConsumo)){
      $grupoId = $grupoConsumo->id;
    }else{
      $grupoId = rand(1, DB::table('grupo_consumos')->count());
    }


    return [
        'grupo_consumo_id' => $grupoId,
        'user_id' => $userId++,
    ];
});
