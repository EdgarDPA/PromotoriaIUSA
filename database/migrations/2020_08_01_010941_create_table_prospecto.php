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
            $table->string('nombre')->nullable();
            $table->string('rfc')->nullable();
            $table->string('contacto')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('referencia')->nullable();
            $table->string('antiguedad')->nullable();
            $table->string('ramo')->nullable();
            $table->string('mensualidad')->nullable();
            $table->string('transporte')->nullable();
            $table->string('mostrador')->nullable();
            $table->string('notas')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('idDistribuidor')->nullable();
            $table->string('nombreDistribuidor')->nullable();
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
