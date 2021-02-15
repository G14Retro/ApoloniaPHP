<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tipo_usuario')->insert([
            'nombre_tipo_usuario' => 'administrador',
            'created_at' => now(),
        ]);

        DB::table('tipo_usuario')->insert([
            'nombre_tipo_usuario' => 'paciente',
            'created_at' => now(),
        ]);

        DB::table('tipo_usuario')->insert([
            'nombre_tipo_usuario' => 'doctor',
            'created_at' => now(),
        ]);
    }
}
