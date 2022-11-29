<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurtidoEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surtido_entradas', function (Blueprint $table) {
            $table->bigIncrements('id_surtido');
            $table->unsignedBigInteger('entrada_articulo_id');
            $table->unsignedBigInteger('vale_surtido_id');
            $table->integer('cantidad')->unsigned();
            $table->foreign('vale_surtido_id')->references('id')->on('vale_surtidos')->onDelete('cascade');
            $table->foreign('entrada_articulo_id')->references('id')->on('entrada_articulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surtido_entradas');
    }
}
