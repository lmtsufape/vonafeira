<?php

use Illuminate\Database\Seeder;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(\projetoGCA\Endereco::class, 50)->create();
    }
}
