<?php

use App\Surgery;
use Illuminate\Database\Seeder;

class SurgerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Surgery::class,6)->create();
    }
}
