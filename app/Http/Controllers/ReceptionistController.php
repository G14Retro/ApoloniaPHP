<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use App\MedicalHistory;
use App\User;
use App\Surgery;
use App\Consultation;
use App\StatusAvailability;
use Carbon\Carbon;


class ReceptionistController extends Controller
{
    public function verDispo ()
    {
        $availability = Availability::join('personas', 'disponibilidadHoraria.id_persona', 'personas.id')
        ->join('estadoDispo', 'disponibilidadHoraria.estado', 'estadoDispo.idEstado')
        ->join('tipo_consulta', 'disponibilidadHoraria.tipo_consulta', 'tipo_consulta.id_consulta')
        ->join('consultorios', 'disponibilidadHoraria.consultorio', 'consultorios.id_consultorio')
        ->select('disponibilidadHoraria.id_disponibilidad AS id', 'personas.nombre AS nombre_medico', 'personas.apellido AS apellido_medico',
        'disponibilidadHoraria.horaInicio AS hora_inicio', 'disponibilidadHoraria.horaFinal AS hora_fin',
        'tipo_consulta.nombre_consulta AS consulta', 'consultorios.nombre_consultorio AS consultorio',
        'estadoDispo.nombreEstado AS disponibilidad')
        ->get();

        if (count($availability) == 0) {
            return response()->json([
                'message' => 'No hay disponibilidad en estos momentos' 
            ]);
        }
        return response()->json($availability);
    }

    public function verMedicos()
    {
        $doctors = User::where('tipo_usuario','=',3)
        ->select('id','nombre','apellido')
        ->get();
        return response()->json($doctors);
    }

    public function verConsultorios()
    {
        $consultorios = Surgery::select('id_consultorio','nombre_consultorio')
        ->get();
        return response()->json($consultorios);
    }

    public function verConsultas()
    {
        $consultas = Consultation::select('id_consulta',
        'nombre_consulta')
        ->get();
        return response()->json($consultas);
    }

    
    public function verDisponibilidades()
    {
        $disponibilidades = StatusAvailability::select('idEstado',
        'nombreEstado')
        ->get();
        return response()->json($disponibilidades);
    }


    public function createDispo(Request $request)
    {
        $crearDispo = Availability::create($request->all());
        return response()->json([
            'message' => 'El registro se ha guardado satisfactoriamente'], 201);    
    }

    public function dispo(Request $request)
    {
        $dispo = Availability::find($request->all());
        return response()->json(
            $dispo);    
    }  

    public function editDispo(Request $request,$id)
    {
        $dispo = Availability::find($id);
        $dispo->update($request->all());
        return response()->json(
            'Registro Actualizado');    
    }  
}
