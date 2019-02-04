<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoConsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_consumos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('descricao')->nullable();
            $table->string('periodo');
            $table->string('dia_semana');
            $table->integer('prazo_pedidos');
            $table->string('estado');
            $table->string('cidade');
            $table->integer('coordenador_id')->unsigned();
            $table->foreign('coordenador_id')->references('id')->on('users');
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
        Schema::dropIfExists('grupo_consumos');
    }
}
