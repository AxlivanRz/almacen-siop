<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValeArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vale_articulos', function (Blueprint $table) {
            $table->unsignedBigInteger('vale_id');
            $table->unsignedBigInteger('articulo_id');
            $table->integer('cantidad')->unsigned();
            $table->timestamps();
            $table->foreign('vale_id')->references('id_vale')->on('vales')->onDelete('cascade');
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade');
            $table->primary(['vale_id', 'articulo_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vale_articulos');
    }
}
