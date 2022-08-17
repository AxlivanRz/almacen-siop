<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncabezadoFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encabezado_facturas', function (Blueprint $table) {
            $table->bigIncrements('id_encabezado_factura');
            $table->string('fecha');
            $table->string('numero_factura');
            $table->string('folio');
            $table->unsignedBigInteger('proveedor_id');
            $table->timestamps();
            $table->foreign('proveedor_id')->references('id_proveedor')->on('proveedores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encabezado_facturas');
    }
}
