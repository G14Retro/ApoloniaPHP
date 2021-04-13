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
            'id' => '#007bff',
            'estado_cita' => 'asignada'
        ]);
        
        DB::table('estado_cita')->insert([
            'id' => '#dc3545',
            'estado_cita' => 'cancelada'
        ]);

        DB::table('estado_cita')->insert([
            'id' => '#17a2b8',
            'estado_cita' => 'confirmada'
        ]);

        DB::table('estado_cita')->insert([
            'id' => '#28a745',
            'estado_cita' => 'asistida'
        ]);
    }
}
