<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diente', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('nombre',50);
            $table->foreignId('posicion')->references('id')->on('posicion_dent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diente');
    }
}
