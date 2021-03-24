<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use App\MedicalHistory;
use App\User;
use Carbon\Carbon;


class ReceptionistController extends Controller
{
    public function paciente(Request $request)
    {
        $request->validate([
            'id_recepcionista'   => 'required|string'
        ]);
        $id_recepcionista = $request->id_recepcionista;
        $availability = Availability::where('dispo.id_persona', '=', $id_recepcionista)
        ->where('citas.estado','=',3)
        ->join('disponibilidadhoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
        ->join('personas','personas.id','citas.id_persona')
        ->select('personas.id AS id','personas.nombre AS nombre_paciente','personas.apellido AS apellido_paciente',
        'dispo.horaInicio AS hora_atencion')
        ->orderBy('hora_atencion','desc')
        ->get();
        if (count($availability)==0) {
            return response()->json(
                [
                    $id_recepcionista,
                    'Message' => 'No tiene citas asignadas para tramitar',
                ]
            );
        }else{
            return response()->json(
                $availability
            );
        }
    }
}
