<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('localidad_id')->nullable();
            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('cascade');
            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados_ordenes')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('ordenes_maestro');
    }
}
