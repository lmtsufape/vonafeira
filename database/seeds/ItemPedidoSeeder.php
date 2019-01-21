<?php

use Illuminate\Database\Seeder;

class ItemPedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(projetoGCA\ItemPedido::class, 500)->create();
    }
}
