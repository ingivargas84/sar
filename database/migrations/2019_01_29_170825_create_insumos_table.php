<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->unsignedInteger('unidad_id');
            $table->foreign('unidad_id')->references('id')->on('unidades_medida')->onDelete('cascade');
            $table->unsignedInteger('categoria_insumo_id');
            $table->foreign('categoria_insumo_id')->references('id')->on('categorias_insumos')->onDelete('cascade');
            $table->unsignedInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('unidades_medida')->onDelete('cascade');
            $table->float('cantidad_medida');
            $table->float('stock_minimo');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('insumos');
    }
}
