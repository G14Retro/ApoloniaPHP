<?php

use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'odontologia general',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'odontopediatria',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'periodoncia',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'rehabilitacion oral',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'implantologia',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'estettica',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'endodoncia',
            'created_at' => now(),
        ]);

        DB::table('tipo_consulta')->insert([
            'nombre_consulta' => 'cirugía oral',
            'created_at' => now(),
        ]);
    }
}
