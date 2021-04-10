<?php

use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_cita')->insert([
            'estado_cita' => 'asignada'
        ]);
        
        DB::table('estado_cita')->insert([
            'estado_cita' => 'cancelada'
        ]);

        DB::table('estado_cita')->insert([
            'estado_cita' => 'confirmada'
        ]);

        DB::table('estado_cita')->insert([
            'estado_cita' => 'asistida'
        ]);
    }
}
