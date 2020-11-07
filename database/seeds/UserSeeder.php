<?php

use App\User;
use App\UserType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idtipousuario = UserType::where('nombre_tipo_usuario', 'doctor')->value('id_tipo');

        factory(User::class,6)->create([
            'tipo_usuario' => $idtipousuario,
            'estado' => 1,
        ]);
    }
}
