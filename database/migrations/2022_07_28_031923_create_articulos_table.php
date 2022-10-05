<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id_articulo');
            $table->integer('clave_articulo')->unsigned();
            $table->string('nombre_articulo', 50);
            $table->string('ubicacion');
            $table->string('observaciones');
            $table->unsignedBigInteger('medida_id'); 
            $table->unsignedBigInteger('partida_id');   
            $table->string('foto_articulo');         
            $table->timestamps();
            $table->foreign('medida_id')->references('id_medida')->on('unidad_medidas')->onDelete('cascade');
            $table->foreign('partida_id')->references('id_partida')->on('partidas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
