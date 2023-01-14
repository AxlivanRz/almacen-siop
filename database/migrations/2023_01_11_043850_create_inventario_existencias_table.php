<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioExistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_existencias', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->unsigned();
            $table->integer('existencia')->unsigned();
            $table->double('precio_unitario')->unsigned();
            $table->double('precio_total')->unsigned();
            $table->date('fecha');
            $table->unsignedBigInteger('articulo_id');
            $table->timestamps();
            $table->foreign('articulo_id')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario_existencias');
    }
}
