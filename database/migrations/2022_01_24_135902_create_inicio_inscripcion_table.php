<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInicioInscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inicio_inscripcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inicio_id');
            $table->unsignedBigInteger('inscripcion_id');
            $table->foreign('inicio_id')->references('id')->on('inicios')->onDelete('cascade');
            $table->foreign('inscripcion_id')->references('id')->on('inscripcions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inicio_inscripcion');
    }
}
