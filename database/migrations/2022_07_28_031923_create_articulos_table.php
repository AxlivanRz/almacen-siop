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
            $table->id();
            $table->string('clave_articulo')->unique();
            $table->string('nombre_articulo');
            $table->string('ubicacion');
            $table->string('observaciones');
            $table->unsignedBigInteger('medida_id'); 
            $table->string('nombre_med');
            $table->unsignedBigInteger('partida_id');   
            $table->string('foto_articulo')->nullable();         
            $table->timestamps();
            $table->foreign('medida_id')->references('id_medida')->on('unidad_medidas')->onDelete('cascade');
            $table->foreign('partida_id')->references('id')->on('partidas')->onDelete('cascade');
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
