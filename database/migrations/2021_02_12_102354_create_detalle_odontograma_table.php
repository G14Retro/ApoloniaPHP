<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleOdontogramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_odontograma', function (Blueprint $table) {
            $table->foreignId('odontograma')->references('id')->on('odontograma');
            $table->foreignId('diente')->references('id')->on('diente');
            $table->foreignId('zona')->references('id')->on('zona');
            $table->foreignId('diagnostico')->references('id')->on('item');
            $table->foreignId('ubicacion')->references('id')->on('ubicacion');
            $table->foreignId('estado')->references('id')->on('tipe_item');
            $table->primary('odontograma');
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
        Schema::dropIfExists('detalle_odontograma');
    }
}
