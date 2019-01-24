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
        factory(projetoGCA\Pedido::class, 50)->create();        
    }
}
