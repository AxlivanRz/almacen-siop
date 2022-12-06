<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id_usuario');
            $table->string('name');
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('nombre_usuario')->unique();
            $table->string('contrasena');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('departamento_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('area_id')->references('id_area')->on('areas')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id_departamento')->on('departamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
