<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('insumo_id');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade');
            $table->unsignedInteger('compra_id');
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            $table->unsignedInteger('movimiento_insumo_id');
            $table->foreign('movimiento_insumo_id')->references('id')->on('movimientos_insumos')->onDelete('cascade');
            $table->float('cantidad');
            $table->float('precio');
            $table->float('subtotal');
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
        Schema::dropIfExists('compras_detalle');
    }
}
