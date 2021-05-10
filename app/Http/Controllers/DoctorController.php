<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\MedicalHistory;
use App\Odontogram;
use App\User;
use Carbon\Carbon;
use App\Token;
use App\UserType;
use App\Status;


class DoctorController extends Controller
{
    public function pacienteMedico(Request $request)
    {
        $request->validate([
            'id_medico'   => 'required|string'
        ]);
        $id_medico = $request->id_medico;
        $appointment = Appointment::where('dispo.id_persona','=',$id_medico)
        ->where('citas.estado','=','#17a2b8')
        ->where('dispo.horaInicio','>',Carbon::now())
        ->join('disponibilidadhoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
        ->join('personas','personas.id','citas.id_persona')
        ->select('citas.id_cita AS id','personas.nombre AS nombre_paciente','personas.apellido AS apellido_paciente',
        'dispo.horaInicio AS hora_atencion')
        ->orderBy('hora_atencion','desc')
        ->get();
        if (count($appointment)==0) {
            return response()->json(
                [
                    'message' => 'No tiene citas asignadas para tramitar',
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
        $id_paciente = Appointment::where('id_cita','=',$request->id_paciente)
        ->value('id_persona');
        $paciente = User::where('personas.id','=',$id_paciente)
        ->join('tipo_documento','tipo_documento.documento','personas.tipo_documento')
        ->select('personas.id AS id','tipo_documento.nombre_documento AS tipo_documento','personas.numero_documento AS numero_documento',
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

    public function verPacientes()
    {
        $tipo_usuario = UserType::where(['nombre_tipo_usuario' => 'paciente'])->value('id_tipo');
        $estado = Status::where(['nombreEstado' => 'activo'])->value('idEstado');
        $pacientes = User::where([
            'tipo_usuario' => $tipo_usuario,
            'estado' => $estado
            ])
        ->select('id','nombre','apellido','numero_documento')
        ->get();
        return response()->json(
            $pacientes
        );
    }

    public function pacienID($id)
    {
        $paciente= User::where('id',$id)
        ->join('tipo_documento','tipo_documento.documento','personas.tipo_documento')
        ->select('tipo_documento.nombre_documento AS tipo_documento','personas.numero_documento AS numero_documento',
        'personas.nombre AS nombre','personas.apellido AS apellido','personas.direccion AS direccion',
        'personas.ciudad AS ciudad','personas.telefono AS telefono','personas.correo AS correo')
        ->get();
        return response()->json(
            $paciente
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
            'cita'                      => 'required|string',
        ]);
        $id_paciente = Appointment::where('id_cita','=',$request->cita)
        ->value('id_persona');
        $medicalhistory = MedicalHistory::where('paciente','=',$id_paciente)
        ->get();
        if (count($medicalhistory)==0) {
            $token = Token::create([
                'paciente' => $id_paciente,
            ]);
            $medicalhistory = new MedicalHistory([
                'alergias'                  => strtolower($request->alergias),
                'enfermedades'              => strtolower($request->enfermedades),
                'enfermedades_familiares'   => strtolower($request->enfermedades_familiares),
                'cirugias'                  => strtolower($request->cirugias),
                'medicamentos'              => strtolower($request->medicamentos),
                'otros'                     => strtolower($request->otros),
                'paciente'                  => $id_paciente,
                ]);
                $medicalhistory->save();
                $availability = Appointment::where('id_persona','=',$id_paciente)
                ->where('id_persona','=',$request->cita)
                ->update(['estado'=>'#28a745']);
                return response()->json([
                'message' => 'El registro se ha guardado satisfactoriamente',
                'ficha' => $token->id], 201);
        }else {
            MedicalHistory::where('paciente','=',$id_paciente)->update([
                'alergias'                  => strtolower($request->alergias),
                'enfermedades'              => strtolower($request->enfermedades),
                'enfermedades_familiares'   => strtolower($request->enfermedades_familiares),
                'cirugias'                  => strtolower($request->cirugias),
                'medicamentos'              => strtolower($request->medicamentos),
                'otros'                     => strtolower($request->otros),
                'paciente'                  => $id_paciente,
            ]);
            $availability = Appointment::where('id_persona','=',$id_paciente)
            ->where('id_cita','=',$request->cita)
            ->update(['estado'=>'#28a745']);
            $token = Token::create([
                'paciente' => $id_paciente,
            ]);
            return response()->json([
                'message' => 'El registro se ha actualizado satisfactoriamente',
                'ficha' => $token->id], 202);
        }
    }

    public function verOdonto($id)
    {
        $odontos = Odontogram::where('ficha.paciente',$id)
        ->join('ficha_dental AS ficha','odontograma.ficha','ficha.id')
        ->select('odontograma.id AS id','odontograma.ficha AS ficha','odontograma.created_at AS fecha_creacion')
        ->get();
        return response()->json($odontos);       
    }

    public function guardarOdonto(Request $request)
    {
        $resultado = Odontogram::where('ficha',$request->ficha)->get();
        if (count($resultado)==0) {
            $odontograma = Odontogram::create($request->all());
            return \response()->json($odontograma->id);
        }else {
            $odontograma = Odontogram::where('ficha',$request->ficha)->update($request->all());
            $odontoID = Odontogram::where('ficha',$request->ficha)->value('id');
            return \response()->json($odontoID);
        }
    }

    public function nuevaFicha(Request $request)
    {
        $ficha = Token::create([
            'paciente' => $request->id
        ]);
        return response()->json([
            'ficha' => $ficha->id
        ]);
    }

    public function obtenerOdonto($id)
    {
        $odonto = Odontogram::where('ficha',$id)->get();
        return \response()->json($odonto);
    }
}
