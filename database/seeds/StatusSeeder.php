<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado')->insert([
            'idEstado' => 'a',
            'nombreEstado' => 'activo'
        ]);

        DB::table('estado')->insert([
            'idEstado' => 'i',
            'nombreEstado' => 'inactivo'
        ]);
        
    }
}
