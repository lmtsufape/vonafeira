<?php

use Illuminate\Database\Seeder;

class ProdutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(\projetoGCA\Produtor::class, 100)->create();
    }
}
