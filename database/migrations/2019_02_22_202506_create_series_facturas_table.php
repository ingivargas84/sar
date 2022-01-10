<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('resolucion')->primary_key();
            $table->string('serie');     
            $table->date('fecha_resolucion');
            $table->date('fecha_vencimiento');
            $table->integer('inicio');
            $table->integer('fin');
            
            $table->unsignedInteger('estado')->default(1);
            $table->foreign('estado')->references('id')->on('estados_series')->onDelete('cascade');

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
        Schema::dropIfExists('series_facturas');
    }
}
