<?php

use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_documento')->insert([
            'documento' => 'cc',
            'nombre_documento' => 'cedula de ciudadania',
            'created_at' => now(),
        ]);
        DB::table('tipo_documento')->insert([
            'documento' => 'ce',
            'nombre_documento' => 'cedula de extrangeria',
            'created_at' => now(),
        ]);
        DB::table('tipo_documento')->insert([
            'documento' => 'pp',
            'nombre_documento' => 'pasaporte',
            'created_at' => now(),
        ]);
        DB::table('tipo_documento')->insert([
            'documento' => 'ti',
            'nombre_documento' => 'tarjeta de identidad',
            'created_at' => now(),
        ]);
    }
}
