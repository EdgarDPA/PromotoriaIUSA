<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idUsuario');
            $table->string('nombreUsuario');
            $table->string('idDistribuidor')->nullable();
            $table->string('nombreDistribuidor')->nullable();
            $table->string('orden_compra');
            $table->string('estatus');
            $table->string('hora');
            $table->string('fecha');
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
        Schema::dropIfExists('orden_compra');
    }
}
