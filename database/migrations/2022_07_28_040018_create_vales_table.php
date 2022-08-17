<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vales', function (Blueprint $table) {
            $table->bigIncrements('id_vale');
            $table->string('cantidad');
            $table->string('status');
            $table->string('fecha');
            $table->unsignedBigInteger('articulo_id');
            $table->unsignedBigInteger('area_id');
            $table->timestamps();
            $table->foreign('articulo_id')->references('id_articulo')->on('articulos')->onDelete('cascade');
            $table->foreign('area_id')->references('id_area')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vales');
    }
}
