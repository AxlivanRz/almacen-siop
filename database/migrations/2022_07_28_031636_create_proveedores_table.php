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
            $table->string('razon_social');
            $table->string('nombre_empresa');
            $table->string('calle')->nullable();
            $table->string('colonia')->nullable();
            $table->integer('codigo_postal')->unsigned();
            $table->string('poblacion');
            $table->string('estado');
            $table->string('pais');
            $table->bigInteger('telefono')->unsigned();
            $table->string('email_proveedor');
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
