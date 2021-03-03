<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\MedicalHistory;
use Carbon\Carbon;


class DoctorController extends Controller
{
    public function pacienteMedico(Request $request)
    {
        $request->validate([
            'id_medico'   => 'required|string'
        ]);
        $id_medico = $request->id_medico;
        $appointment = Appointment::where('dispo.id_persona','=',$id_medico)
        ->join('disponibilidadhoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
        ->join('personas','personas.id','citas.id_persona')
        ->select('personas.id AS id','personas.nombre AS nombre_paciente','personas.apellido AS apellido_paciente',
        'dispo.horaInicio AS hora_atencion')
        ->orderBy('hora_atencion','desc')
        ->get();
        if (count($appointment)==0) {
            return response()->json(
                [
                    $id_medico,
                    'Message' => 'No tiene citas asignadas para tramitar',
                ]
               );
        }else{
            return response()->json(
                $appointment
               );
        }
    }

    public function verAntecedentes(Request $request)
    {
        $request->validate([
            'id_paciente'   => 'required|string'
        ]);
        $id_paciente = $request->id_paciente;
        $antecedente = MedicalHistory::where('paciente','=',$id_paciente);

        return response()->json(
            $antecedente
           );
    }

    public function guardarAntecedente(Type $var = null)
    {
        $request->validate([
            'id_paciente'               => 'required|string',
            'alergias'                  => 'required|string',
            'enfermedades'              => 'required|string',
            'enfermedades_familiares'   => 'required|string',
            'cirugias'                  => 'required|string',
            'medicamentos'              => 'required|string',
            'otros'                     => 'required|string',
            'paciente'                  => 'required|string',
        ]);
        
        $medicalhistory = new MedicalHistory([
            'alergias'                  => $request->alergias,
            'enfermedades'              => $request->enfermedades,
            'enfermedades_familiares'   => $request->enfermedades_familiares,
            'cirugias'                  => $request->cirugias,
            'medicamentos'              => $request->medicamentos,
            'otros'                     => $request->otros,
            'paciente'                  => $request->id_paciente,
            ]);
        $medicalhistory->save();
        return response()->json([
            'message' => 'El registro se ha guardado satisfactoriamente'], 201);
    }
}
