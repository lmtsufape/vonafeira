<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalRetiradaEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_retirada_eventos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evento_id');
            $table->integer('localretirada_id');

            $table->foreign('evento_id')->references('id')->on('eventos');
            $table->foreign('localretirada_id')->references('id')->on('local_retiradas');
            
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
        Schema::dropIfExists('local_retirada_eventos');
    }
}
