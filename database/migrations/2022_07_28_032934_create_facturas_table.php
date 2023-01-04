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
            $table->string('respaldo_factura')->nullable();
            $table->double('iva')->unsigned();
            $table->double('subtotal')->unsigned();
            $table->double('imp_total')->unsigned();
            $table->double('imp_iva')->unsigned();
            $table->boolean('confirmed')->default(0);
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('recurso_id');
            $table->timestamps();
            $table->foreign('proveedor_id')->references('id_proveedor')->on('proveedores')->onDelete('cascade');
            $table->foreign('recurso_id')->references('id_origen')->on('origen_recursos')->onDelete('cascade');
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
