<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaInforuta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inforuta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_ruta')->nullable();
            $table->string('orden_ruta')->nullable();       
            $table->string('estatus')->nullable(); 
            $table->string('fecha_inicio')->nullable();
            $table->string('hora_inicio')->nullable(); 
            $table->string('fecha_final')->nullable();
            $table->string('hora_final')->nullable();       
            $table->string('id_promotor')->nullable();
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
        Schema::dropIfExists('inforuta');
    }
}
