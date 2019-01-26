<?php

use Illuminate\Database\Seeder;

class LocalRetiradaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10; $i++) {

          factory(\projetoGCA\LocalRetirada::class)->create([
              'grupoconsumo_id' => $i,
          ]);

          factory(\projetoGCA\LocalRetirada::class)->create([
              'grupoconsumo_id' => $i,
          ]);

          factory(\projetoGCA\LocalRetirada::class)->create([
              'grupoconsumo_id' => $i,
          ]);
        }
    }
}
