<?php

use Illuminate\Database\Seeder;

class LocalRetiradaEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $eventoId = 0;

      for ($i=0; $i <= 29; $i++) {

        if($i%3 == 0){
          $eventoId++;
        }

        factory(\projetoGCA\LocalRetiradaEvento::class)->create([
          'evento_id' => $eventoId,
          'localretirada_id' => $i+1,
        ]);

      }
    }
}
