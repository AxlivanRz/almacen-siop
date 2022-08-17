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
            $table->string('cantidad');
            $table->string('descuento');
            $table->string('precio');
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('factura_id');
            $table->timestamps();
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade');
            $table->foreign('factura_id')->references('id_factura')->on('facturas')->onDelete('cascade');
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
