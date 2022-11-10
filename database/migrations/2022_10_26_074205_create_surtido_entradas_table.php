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
            $table->unsignedBigInteger('surtido_id');
            $table->unsignedBigInteger('entrada_id');
            $table->integer('cantidad')->unsigned();
            $table->foreign('surtido_id')->references('id_surtido')->on('vale_surtidos')->onDelete('cascade');
            $table->foreign('entrada_id')->references('id_precio_entrada')->on('entrada_articulos')->onDelete('cascade');
            $table->primary(['surtido_id', 'entrada_id']);
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
