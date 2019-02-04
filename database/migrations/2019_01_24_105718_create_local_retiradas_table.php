<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalRetiradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_retiradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('grupoconsumo_id')->unsigned();
            $table->foreign('grupoconsumo_id')->references('id')->on('grupo_consumos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_retiradas');
    }
}
