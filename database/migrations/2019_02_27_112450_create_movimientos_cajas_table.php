<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('caja_id');
            $table->string('descripcion');
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
            $table->float('ingreso');
            $table->float('salida');
            $table->float('saldo');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('movimientos_cajas');
    }
}
