<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_produtor');
            $table->integer('grupoconsumo_id')->unsigned();
            $table->foreign('grupoconsumo_id')->references('id')->on('grupo_consumos');
            $table->double('preco');
            $table->string('nome');
            $table->string('descricao');
            $table->integer('unidadevenda_id')->unsigned();
            $table->foreign('unidadevenda_id')->references('id')->on('unidade_vendas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
