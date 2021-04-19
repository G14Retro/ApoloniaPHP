<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserType;
use App\TypeDocument;
use App\Status;




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
        $usuarios = User::all();
        return response()->json($usuarios);
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
    $usuarios =User::create($request->all());
    
    return response()->json(
        [
            'Message' => 'Usuario creado correctamente',
        ]
    );
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buscarUsuario(Request $request)
    {
        //
        $usuario = User::find($request->id_paciente);
        return response ()->json($usuario);
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
    public function actualizarUsuario(Request $request)
    {
        //
        $usuario = User::findOrFail($request->id);
        $usuario->update($request->all());
        return $usuario;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    
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
}
