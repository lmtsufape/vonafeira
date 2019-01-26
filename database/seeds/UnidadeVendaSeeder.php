<?php

use Illuminate\Database\Seeder;

class UnidadeVendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $grupoId = 0;

      for ($i=0; $i <= 49; $i++) {

        if($i%5 == 0){
          $grupoId++;
        }

        factory(\projetoGCA\UnidadeVenda::class)->create([
          'grupoConsumoId' => $grupoId,
        ]);

      }
    }
}
