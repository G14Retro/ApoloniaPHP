<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisponibilidadHorariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilidadHoraria', function (Blueprint $table) {
            $table->id('id_disponibilidad');
            $table->foreignId('id_persona')->references('id')->on('personas');
            $table->dateTime('horaInicio');
            $table->dateTime('horaFinal');
            $table->foreignId('estado',1)->references('idEstado')->on('estadoDispo');
            $table->foreignId('tipo_consulta')->references('id_consulta')->on('tipo_consulta');
            $table->foreignId('consultorio')->references('id_consultorio')->on('consultorios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibilidadHoraria');
    }
}
