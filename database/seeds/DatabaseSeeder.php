<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UserSeeder::class);
      $this->call(GrupoConsumoSeeder::class);
      $this->call(UnidadeVendaSeeder::class);
      $this->call(ProdutorSeeder::class);
      $this->call(ProdutoSeeder::class);
      $this->call(EventoSeeder::class);
      $this->call(ConsumidorSeeder::class);
      $this->call(PedidoSeeder::class);
      $this->call(ItemPedidoSeeder::class);
    }
}
