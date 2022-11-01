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
            $table->integer('status')->unsigned();
            $table->dateTime('fecha');
            $table->dateTime('fecha_aprovado')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('administrador_id')->nullable();
            $table->timestamps();
            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');
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
