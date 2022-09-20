<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('id_proveedor');
            $table->string('razon_social', 50);
            $table->string('nombre_empresa', 50);
            $table->string('calle', 50)->nullable();
            $table->string('colonia', 50)->nullable();
            $table->integer('codigo_postal')->unsigned();
            $table->string('poblacion', 50);
            $table->string('estado', 50);
            $table->string('pais', 50);
            $table->integer('telefono')->unsigned();
            $table->string('email_proveedor', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
