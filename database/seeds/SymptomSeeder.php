<?php

use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sintomas')->insert([
            ['nombre_sintoma' => '41',
            'color' => 'incisivo central'],
        ]);
    }
}
