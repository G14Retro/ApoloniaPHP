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
            ['representacion' => '#007bff',
            'estado_cita' => 'asignada'],
            ['representacion' => '#dc3545',
            'estado_cita' => 'cancelada'],
            ['representacion' => '#17a2b8',
            'estado_cita' => 'confirmada'],
            ['representacion' => '#28a745',
            'estado_cita' => 'asistida']
        ]);
        
    }
}
