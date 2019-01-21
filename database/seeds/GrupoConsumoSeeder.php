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
      factory(projetoGCA\GrupoConsumo::class, 10)->create();
    }
}
