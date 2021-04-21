<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispoTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER cambioDispo AFTER INSERT ON citas
        FOR EACH ROW
        UPDATE disponibilidadhoraria SET estado = 2 WHERE id_disponibilidad = NEW.disponibilidad;');
        DB::unprepared('CREATE TRIGGER dispoActiva AFTER UPDATE ON citas
        FOR EACH ROW
        UPDATE disponibilidadhoraria SET estado = 1 WHERE id_disponibilidad = NEW.disponibilidad;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS cambioDispo');
        DB::unprepared('DROP TRIGGER IF EXISTS dispoActiva');
    }
}
