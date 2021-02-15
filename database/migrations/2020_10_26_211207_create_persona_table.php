<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->char("tipo_documento",10);
            $table->string("numero_documento",25)->unique();
            $table->string('nombre',45);
            $table->string('apellido',45);
            $table->string('direccion',45);
            $table->string('ciudad',45);
            $table->string('telefono',45);
            $table->string('correo',45)->unique();
            $table->string('genero',10);
            $table->date('fecha_nacimiento');
            $table->foreignId('tipo_usuario')->references('id_tipo')->on('tipo_usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->char('estado',10);
            $table->foreign('estado')->references('idEstado')->on('estado');
            $table->foreign('tipo_documento')->references('documento')->on('tipo_documento');
            $table->rememberToken();
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
        Schema::dropIfExists('personas');
    }
}
