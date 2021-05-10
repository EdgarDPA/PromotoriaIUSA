<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProspecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospecto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('rfc');
            $table->string('contacto');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('correo');
            $table->string('referencia');
            $table->string('antiguedad');
            $table->string('ramo');
            $table->string('mensualidad');
            $table->string('transporte');
            $table->string('mostrador');
            $table->string('notas');
            $table->string('id_oportunidad')->nullable();
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
        Schema::dropIfExists('prospecto');
    }
}
