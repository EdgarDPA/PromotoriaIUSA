<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pregunta1')->nullable();
            $table->string('pregunta2')->nullable();
            $table->string('pregunta3')->nullable();
            $table->string('pregunta4')->nullable();
            $table->string('pregunta5')->nullable();
            $table->string('pregunta6')->nullable();
            $table->string('pregunta7')->nullable();
            $table->string('pregunta8')->nullable();
            $table->string('pregunta9')->nullable();
            $table->string('pregunta10')->nullable();
            $table->string('fecha')->nullable();
            $table->string('hora')->nullable();
            $table->string('id_oportunidad');
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
        Schema::dropIfExists('encuesta');
    }
}
