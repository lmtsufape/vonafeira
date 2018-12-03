<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grupoconsumo_id')->unsigned();
            $table->foreign('grupoconsumo_id')->references('id')->on('grupo_consumos');
            $table->integer('coordenador_id')->unsigned();
            $table->foreign('coordenador_id')->references('id')->on('users');
            $table->date('data_inicio_pedidos');
            $table->date('data_fim_pedidos');
            $table->date('data_evento');
            $table->string('hora_evento');
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
        Schema::dropIfExists('eventos');
    }
}
