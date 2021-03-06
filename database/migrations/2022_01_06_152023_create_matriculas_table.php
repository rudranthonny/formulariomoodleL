<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->integer('user_id');
            $table->double('costo');
            $table->string('agente')->nullable();
            $table->string('tipo')->nullable();
            $table->date('fechapago')->nullable();
            $table->string('comprobante')->nullable();
            $table->string('comprobante_imagen')->unique()->nullable();
            $table->unsignedBigInteger('programa_id')->nullable();
            $table->unsignedBigInteger('inscripcion_id');
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('set null');
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
        Schema::dropIfExists('matriculas');
    }
}
