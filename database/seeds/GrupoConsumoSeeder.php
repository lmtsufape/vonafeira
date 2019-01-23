<?php

use Illuminate\Database\Seeder;

class GrupoConsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(\projetoGCA\GrupoConsumo::class)->create([
          'name' => "Fruto da Terra",
      ]);

      factory(projetoGCA\GrupoConsumo::class, 9)->create();
    }
}
