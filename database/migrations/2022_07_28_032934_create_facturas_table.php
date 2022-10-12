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
            $table->date('fecha');
            $table->bigInteger('numero_factura')->unique();
            $table->string('folio');
            $table->string('respaldo_factura');
            $table->double('iva');
            $table->double('imp_total');
            $table->double('imp_iva');
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
        Schema::dropIfExists('facturas');
    }
}
