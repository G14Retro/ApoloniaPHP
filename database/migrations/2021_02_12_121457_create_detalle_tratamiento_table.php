<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTratamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_tratamiento', function (Blueprint $table) {
            $table->foreignId('tratamiento')->references('id')->on('tratamiento');
            $table->foreignId('pieza_paciente')->references('id')->on('pieza_paciente');
            $table->string('comentario');
            $table->primary(['tratamiento','pieza_paciente']);
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
        Schema::dropIfExists('detalle_tratamiento');
    }
}
