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
            'tipo_usuario','tipo_consulta','personas','consultorios','tipo_documento','estado_cita','estado',
            'estadoDispo','dientes'
        ]);
        // $this->call(UserSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(TypeDocumentSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ConsultationSeeder::class);
        $this->call(AvailabilityStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SurgerySeeder::class);
        $this->call(AppointmentStatusSeeder::class);
        $this->call(DentSeeder::class);
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
