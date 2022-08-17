<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValeSurtidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vale_surtidos', function (Blueprint $table) {
            $table->bigIncrements('id_surtido');
            $table->string('cantidad');
            $table->string('precio_unitario');
            $table->string('total');
            $table->string('fecha');
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('vale_id');
            $table->timestamps();
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade');
            $table->foreign('vale_id')->references('id_vale')->on('vales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vale_surtidos');
    }
}
