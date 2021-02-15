<?php

use App\User;
use App\UserType;
use App\TypeDocument;
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
        $cc = TypeDocument::where('documento', 'cc')->value('documento');

        factory(User::class,6)->create([
            'tipo_documento' => $cc,
            'tipo_usuario' => $idtipousuario,
            'estado' => 'a',
        ]);
    }
}
