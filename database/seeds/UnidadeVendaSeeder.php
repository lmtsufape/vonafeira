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
        DB::table('unidade_vendas')->insert(['nome' => "UND", 'descricao' => "Unidade",'is_fracionado' => false, 'is_porcao' => true ]);
        DB::table('unidade_vendas')->insert(['nome' => "KG", 'descricao' => "Quilo",'is_fracionado' => true, 'is_porcao' => true ]);

    }
}
