<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenCompraDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_detalle', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('codigo_material');
            $table->string('nombre_material');
            $table->string('unidades_confirmadas');
            $table->bigInteger('orden_compra_id')->unsigned();
            $table->foreign('orden_compra_id')->references('id')->on('orden_compra')->onDelete('cascade'); 
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
        Schema::dropIfExists('orden_compra_detalle');
    }
}
