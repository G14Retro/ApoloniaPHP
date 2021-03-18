<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\MedicalHistory;
use App\User;
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
        ->where('citas.estado','=',3)
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
        $paciente = User::where('personas.id','=',$id_paciente)
        ->join('tipo_documento','tipo_documento.documento','personas.tipo_documento')
        ->select('tipo_documento.nombre_documento AS tipo_documento','personas.numero_documento AS numero_documento',
        'personas.nombre AS nombre','personas.apellido AS apellido')
        ->get();
        $antecedente = MedicalHistory::where('paciente','=',$id_paciente)
        ->select('alergias','enfermedades','enfermedades_familiares','cirugias','medicamentos','otros','paciente')
        ->get();

        return response()->json(
            ['paciente' => $paciente,
            'antecedente' => $antecedente]
           );
    }

    public function guardarAntecedente(Request $request)
    {
        $request->validate([
            'alergias'                  => 'required|string',
            'enfermedades'              => 'required|string',
            'enfermedades_familiares'   => 'required|string',
            'cirugias'                  => 'required|string',
            'medicamentos'              => 'required|string',
            'otros'                     => 'required|string',
            'paciente'                  => 'required|string',
        ]);
        $medicalhistory = MedicalHistory::where('paciente','=',$request->paciente)
        ->get();
        if (count($medicalhistory)==0) {
            $medicalhistory = new MedicalHistory([
                'alergias'                  => strtolower($request->alergias),
                'enfermedades'              => strtolower($request->enfermedades),
                'enfermedades_familiares'   => strtolower($request->enfermedades_familiares),
                'cirugias'                  => strtolower($request->cirugias),
                'medicamentos'              => strtolower($request->medicamentos),
                'otros'                     => strtolower($request->otros),
                'paciente'                  => strtolower($request->paciente),
                ]);
                $medicalhistory->save();
                $availability = Appointment::where('id_persona','=',$request->paciente)
                ->update(['estado'=>4]);
            return response()->json([
                'message' => 'El registro se ha guardado satisfactoriamente'], 201);
        }else {
            MedicalHistory::where('paciente','=',$request->paciente)->update($request->all());
            $availability = Appointment::where('id_persona','=',$request->paciente)
            ->update(['estado'=>4]);
            return response()->json([
                'message' => 'El registro se ha actualizado satisfactoriamente'], 202);
        }
    }

}
