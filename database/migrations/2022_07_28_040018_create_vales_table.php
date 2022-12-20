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
            $table->id();
            $table->integer('status')->unsigned();
            $table->dateTime('fecha');
            $table->dateTime('fecha_aprovado')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('administrador_id')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->timestamps();
            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id_area')->on('areas')->onDelete('cascade');
            $table->foreign('administrador_id')->references('id_usuario')->on('users')->onDelete('cascade');
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
