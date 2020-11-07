<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'tipo_usuario','tipo_consulta','personas','consultorios'
        ]);
        // $this->call(UserSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(ConsultationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SurgerySeeder::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table)
        {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
