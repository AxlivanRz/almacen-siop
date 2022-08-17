<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id_factura');
            $table->string('imp_iva');
            $table->string('imp_total');
            $table->string('imp_unitario');
            $table->string('imp_factura');
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('encabezado_id');
            $table->timestamps();
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade')->onDelete('cascade');
            $table->foreign('encabezado_id')->references('id_encabezado_factura')->on('encabezado_facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
