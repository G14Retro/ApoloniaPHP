<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('odontograma')->references('id')->on('odontograma');
            $table->string('diente',10);
            $table->foreign('diente')->references('numero')->on('dientes');
            $table->string('superficie',10)->nullable();
            $table->foreignId('sintomas')->references('id')->on('sintomas');      
            $table->string('observacion')->nullable();
            $table->foreignId('tratamiento')->references('id')->on('tratamiento');      
            $table->string('valor_tratamiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostico');
    }
}
