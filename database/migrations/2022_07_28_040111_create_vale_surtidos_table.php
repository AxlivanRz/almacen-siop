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
            $table->double('total')->unsigned();
            $table->dateTime('fecha');
            $table->unsignedBigInteger('vale_id');
            $table->unsignedBigInteger('capturista_id');
            $table->timestamps();
            $table->foreign('vale_id')->references('id')->on('vales')->onDelete('cascade');
            $table->foreign('capturista_id')->references('id_usuario')->on('users')->onDelete('cascade');
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
