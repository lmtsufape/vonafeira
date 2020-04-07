<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('consumidor_id')->unsigned();
            $table->foreign('consumidor_id')->references('id')->on('consumidors');

            $table->integer('evento_id')->unsigned();
            $table->foreign('evento_id')->references('id')->on('eventos');

            $table->integer('localretiradaevento_id');
            $table->foreign('localretiradaevento_id')->references('id')->on('local_retirada_eventos');
           
            $table->date('data_pedido');
            $table->boolean('is_confirmado');
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
        Schema::dropIfExists('pedidos');
    }
}
