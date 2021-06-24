<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaEvidenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_evidencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('foto');
            $table->string('seccion');           
            $table->bigInteger('agenda_id')->unsigned(); 
            $table->foreign('agenda_id')->references('id')->on('agenda')->onDelete('cascade');
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
        Schema::dropIfExists('agenda_evidencia');
    }
}
