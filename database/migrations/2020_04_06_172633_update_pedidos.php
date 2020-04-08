<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('localretiradaevento_id')->nullable()->change();

            $table->integer('endereco_consumidor_id')->unsigned()->nullable();
            $table->foreign('endereco_consumidor_id')->references('endereco_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['endereco_consumidor_id']);

            $table->dropColumn('endereco_consumidor_id');
        });
    }
}
