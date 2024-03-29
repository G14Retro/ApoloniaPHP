<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Availability;
use Illuminate\Http\Request;
use App\User;
use App\UserType;
use App\TypeDocument;
use App\Status;
use App\Treatment;
use App\Symptom;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarPacientes()
    {
         //
        $usuarios = User::join('tipo_documento','personas.tipo_documento','tipo_documento.documento')
        ->join('tipo_usuario','personas.tipo_usuario','tipo_usuario.id_tipo')
        ->join('estado','personas.estado','estado.idEstado')
        ->select('personas.id AS id','tipo_documento.nombre_documento AS tipo_documento','personas.numero_documento AS numero_documento',
        'personas.nombre AS nombre','personas.apellido AS apellido', 'personas.direccion AS direccion', 'personas.ciudad AS ciudad',
        'personas.telefono AS telefono', 'personas.correo AS correo','personas.genero AS genero', 'personas.fecha_nacimiento AS fecha_nacimiento',
        'tipo_usuario.nombre_tipo_usuario AS nombre_tipo_usario', 'estado.nombreEstado AS nombreEstado')
        ->get();
        return response()->json($usuarios);
    }
    
    public function listarTratamientos()
    {
        return Treatment::all();
    }
    public function listarSintomas()
    {
        return Symptom::all();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crearUsuario(Request $request)
    {
        //
        $user = new User([
            'tipo_documento'   => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'nombre'           => strtolower($request->nombre),
            'apellido'         => strtolower($request->apellido),
            'direccion'        => $request->direccion,
            'ciudad'           => $request->ciudad,
            'telefono'         => $request->telefono,
            'correo'           => strtolower($request->correo),
            'genero'           => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_usuario'     => $request->tipo_usuario,
            'password'         => bcrypt($request->password),
            'estado'           => $request->estado,
            [
                'numero_documento.unique'   => 'El número de documento ya se encuentra registrado',
                'correo.unique'             => 'Este correo ya se encuentra registrado'
            ]
        ]);
        $user->save();
    return response()->json('Usuario creado correctamente');


    }
    public function crearTratamiento(Request $request)
    {
        //
        $tratamiento = new Treatment([
            'nombre_tratamiento'   => $request->nombre_tratamiento,
            'valor_tratamiento' => $request->valor_tratamiento,


        ]);
        $tratamiento->save();
    return response()->json('Tratamiento creado correctamente');


    }
    public function crearSintomas(Request $request)
    {
        //
        $sintomas = new Symptom([
            'nombre_sintoma'   => $request->nombre_sintoma,
            'color' => $request->color,

        ]);
        $sintomas->save();
    return response()->json('Sintoma creado correctamente');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscarUsuario($id)
    {
        //
        $usuario = User::find($id);
        return response ()->json($usuario);
    }
    public function buscarTratamiento(Request $request)
    {
        //
        $tratamiento = Treatment::find($request);
        return response ()->json($tratamiento);
    }
    public function buscarSintoma(Request $request)
    {
        //
        $sintoma = Symptom::find($request);
        return response ()->json($sintoma);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editarUsuario(Request $request)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizarUsuario(Request $request,$id)
    {
        //
        $request-> password= bcrypt($request->password);
        $usuario = User::findOrFail($id);
        $usuario->update([
            'tipo_documento'   => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'nombre'           => strtolower($request->nombre),
            'apellido'         => strtolower($request->apellido),
            'direccion'        => $request->direccion,
            'ciudad'           => $request->ciudad,
            'telefono'         => $request->telefono,
            'correo'           => strtolower($request->correo),
            'genero'           => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'tipo_usuario'     => $request->tipo_usuario,
            'password'         => bcrypt($request->password),
            'estado'           => $request->estado,
        ]);
        return response()->json('Registro actualizado correctamente');
    }
    public function actualizarTratamiento(Request $request,$id)
    {
        //
        $tratamiento = Treatment::findOrFail($id);
        $tratamiento->update([
            'nombre_tratamiento'   => $request->nombre_tratamiento,
            'valor_tratamiento' => $request->valor_tratamiento,
        ]);
        return response()->json('Registro actualizado correctamente');
    }
    public function actualizarSintoma(Request $request,$id)
    {
        //
        $sintoma = Symptom::findOrFail($id);
        $sintoma->update([
            'nombre_sintoma'   => $request->nombre_sintoma,
            'color' => $request->color,
        ]);
        return response()->json('Registro actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function elimiarTratamiento($id)
    {
        $tratamiento = Treatment::find($id);
        $tratamiento->delete();
        return response()->json(
            'Registro Eliminado');

    }
    public function elimiarSintoma($id)
    {
        $sintoma = Symptom::find($id);
        $sintoma->delete();
        return response()->json(
            'Registro Eliminado');

    }
    public function verDocumento()
    {
        $documento = TypeDocument::all();
        return response()->json($documento);
    }
    public function verGenero()
    {
        $genero = User::select('genero')
        ->get();
        return response()->json($genero);
    }
    public function verEstado()
    {
        $estado = Status::select('idEstado','nombreEstado')
        ->get();
        return response()->json($estado);
    }
    public function verTusuario()
    {
        $tusuario = UserType::select('nombre_tipo_usuario','id_tipo')
        ->get();
        return response()->json($tusuario);
    }

    //Obtener datos para el dashboard
    public function adminDash()
    {
        $tipo_asignada = DB::table('estado_cita')->where('estado_cita','asignada')->value('id');
        $tipo_asistida = DB::table('estado_cita')->where('estado_cita','asistida')->value('id');
        $tipo_cancelada = DB::table('estado_cita')->where('estado_cita','cancelada')->value('id');
        $estado_disponible = DB::table('estadodispo')->where('nombreEstado','disponible')->value('idEstado');
        $asignadas = Appointment::where('estado',$tipo_asignada)->get();
        $asistidas = Appointment::where('estado',$tipo_asistida)->get();
        $canceladas = Appointment::where('estado',$tipo_cancelada)->get();
        $disponibilidades = Availability::where('estado',$estado_disponible)->get();
        $activos = User::where('estado','a')->get();
        $inactivos = User::where('estado','i')->get();

        return response()->json([
            'asignadas' => count($asignadas),
            'asistidas' => count($asistidas),
            'canceladas' => count($canceladas),
            'disponibilidades' => count($disponibilidades),
            'activos' => count($activos),
            'inactivos' => count($inactivos),
        ]);
    }
}
