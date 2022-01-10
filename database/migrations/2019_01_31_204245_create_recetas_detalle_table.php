<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecetasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recetas_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receta_id');
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade');
            $table->unsignedInteger('insumo_id');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
            //$table->unsignedInteger('unidad_medida_id');
            //$table->foreign('unidad_medida_id')->references('id')->on('insumos')->onDelete('cascade');
            $table->float('cantidad');
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
        Schema::dropIfExists('recetas_detalle');
    }
}
