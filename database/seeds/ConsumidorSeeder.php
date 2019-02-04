<?php

use Illuminate\Database\Seeder;

class ConsumidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(projetoGCA\Consumidor::class, 50)->create();
    }
}
