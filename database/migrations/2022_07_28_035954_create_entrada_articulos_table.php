<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_articulos', function (Blueprint $table) {
            $table->bigIncrements('id_precio_entrada');
            $table->integer('cantidad');
            $table->double('descuento');
            $table->double('base');
            $table->double('precio');
            $table->double('imp_unitario');
            $table->unsignedBigInteger('articulo_id');
            $table->bigInteger('factura_id')->unsigned();
            $table->timestamps();
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_articulos');
    }
}
