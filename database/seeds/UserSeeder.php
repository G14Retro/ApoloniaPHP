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

        factory(User::class,10)->create([
            'tipo_documento' => $cc,
            'tipo_usuario' => $idtipousuario,
            'estado' => 'a',
        ]);

        DB::table('personas')->insert([
            'tipo_documento'        => $cc,
            'numero_documento'      => '987654321',
            'nombre'                => 'paciente',
            'apellido'              => 'apolonia',
            'direccion'             => 'calle false 123',
            'ciudad'                => 'bogotá',
            'telefono'              => '3204259625',
            'correo'                => 'paciente@ejemplo.com',
            'genero'                => 'masculino',
            'fecha_nacimiento'      => '1994-03-09',
            'tipo_usuario'          => '2',
            'password'              => bcrypt('123456'),
            'estado'                => 'a',
        ]);
        DB::table('personas')->insert([
            'tipo_documento'        => $cc,
            'numero_documento'      => '10229029',
            'nombre'                => 'medico',
            'apellido'              => 'apolonia',
            'direccion'             => 'calle false 123',
            'ciudad'                => 'bogotá',
            'telefono'              => '3204259625',
            'correo'                => 'medico@ejemplo.com',
            'genero'                => 'masculino',
            'fecha_nacimiento'      => '1994-03-09',
            'tipo_usuario'          => '3',
            'password'              => bcrypt('123456'),
            'estado'                => 'a',
        ]);

        DB::table('personas')->insert([
            'tipo_documento'        => $cc,
            'numero_documento'      => '12345678',
            'nombre'                => 'recepcion',
            'apellido'              => 'apolonia',
            'direccion'             => 'calle false 123',
            'ciudad'                => 'bogotá',
            'telefono'              => '3204259625',
            'correo'                => 'recepcion@ejemplo.com',
            'genero'                => 'masculino',
            'fecha_nacimiento'      => '1994-03-09',
            'tipo_usuario'          => '4',
            'password'              => bcrypt('123456'),
            'estado'                => 'a',
        ]);

        DB::table('personas')->insert([
            'tipo_documento'        => $cc,
            'numero_documento'      => '1234567885',
            'nombre'                => 'administrador',
            'apellido'              => 'apolonia',
            'direccion'             => 'calle false 123',
            'ciudad'                => 'bogotá',
            'telefono'              => '3204259625',
            'correo'                => 'admin@ejemplo.com',
            'genero'                => 'masculino',
            'fecha_nacimiento'      => '1994-03-09',
            'tipo_usuario'          => '1',
            'password'              => bcrypt('123456'),
            'estado'                => 'a',
        ]);
    }
}
