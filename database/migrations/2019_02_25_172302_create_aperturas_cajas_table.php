<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAperturasCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aperturas_cajas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('caja_id')->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade')->nullable();
            $table->unsignedInteger('user_aperturo_id')->nullable();
            $table->foreign('user_aperturo_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_cajero_id')->nullable();
            $table->foreign('user_cajero_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_cerro_id')->nullable();
            $table->foreign('user_cerro_id')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('fecha_apertura')->nullable();
            $table->datetime('fecha_cierre')->nullable();
            $table->boolean('estado')->default(0);
            $table->float('monto')->nullable();
            $table->float('monto_cierre')->nullable();
            $table->float('sobrante')->nullable();
            $table->float('faltante')->nullable();
            $table->float('efectivo')->nullable();
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
        Schema::dropIfExists('aperturas_cajas');
    }
}
