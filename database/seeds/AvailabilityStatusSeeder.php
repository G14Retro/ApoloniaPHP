<?php

use Illuminate\Database\Seeder;

class AvailabilityStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estadodispo')->insert([
            'nombreEstado' => 'disponible'
        ]);

        DB::table('estadodispo')->insert([
            'nombreEstado' => 'no disponible'
        ]);
    }
}
