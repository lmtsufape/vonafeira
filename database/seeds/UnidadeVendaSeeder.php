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
      factory(\projetoGCA\UnidadeVenda::class, 50)->create();
    }
}
