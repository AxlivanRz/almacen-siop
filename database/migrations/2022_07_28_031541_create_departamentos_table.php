<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->bigIncrements('id_departamento');
            $table->string('nombre_departamento', 40);
            $table->string('descripcion_departamento', 40);
            $table->unsignedBigInteger('area_id');
            $table->string('encargado_departamento', 40);
            $table->timestamps();
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
        Schema::dropIfExists('departamentos');
    }
}
