<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('rol_id')->references('id_rol')->on('rols')->onDelete('cascade');
            $table->primary(['usuario_id', 'rol_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol_usuarios');
    }
}
