<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use App\MedicalHistory;
use App\User;
use App\Surgery;
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
}
