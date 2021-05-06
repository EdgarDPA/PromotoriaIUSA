<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOportunidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oportunidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Id_INEGI');
            $table->string('Nombre');
            $table->string('Razon_social')->nullable();
            $table->string('Clase_actividad')->nullable();
            $table->string('Estrato')->nullable();
            $table->string('Tipo_vialidad')->nullable();
            $table->string('Calle')->nullable();
            $table->string('Num_Exterior')->nullable();
            $table->string('Num_Interior')->nullable();
            $table->string('Colonia')->nullable();
            $table->string('CP')->nullable();
            $table->string('Ubicacion')->nullable();
            $table->string('Telefono')->nullable();
            $table->string('Correo_e')->nullable();
            $table->string('Sitio_internet')->nullable();
            $table->string('Tipo')->nullable();
            $table->string('Longitud')->nullable();
            $table->string('Latitud')->nullable();
            $table->string('tipo_corredor_industrial')->nullable();
            $table->string('nom_corredor_industrial')->nullable();
            $table->string('numero_local')->nullable();
            $table->string('id_zona')->nullable();
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
        Schema::dropIfExists('oportunidades');
    }
}
