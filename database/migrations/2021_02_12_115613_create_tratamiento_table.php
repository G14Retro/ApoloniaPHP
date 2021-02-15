<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTratamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamiento', function (Blueprint $table) {
            $table->id();
            $table->text('comentario');
            $table->string('nombre',45);
            $table->string('descripcion',200);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('valor',45);
            $table->string('estado',45);
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
        Schema::dropIfExists('tratamiento');
    }
}
