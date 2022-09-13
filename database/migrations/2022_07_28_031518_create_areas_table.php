<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->bigIncrements('id_area');
            $table->string('nombre_area', 40);
            $table->string('descripcion_area', 40);
            $table->unsignedBigInteger('up_id');
            $table->string('encargado_area', 40);
            $table->timestamps();
            $table->foreign('up_id')->references('id_up')->on('ups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
