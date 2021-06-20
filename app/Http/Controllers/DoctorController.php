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
use App\Dent;
use App\Symptom;
use App\Treatment;
use App\Diagnosis;
use App\StatusAppointment;

class DoctorController extends Controller
{
    public function pacienteMedico(Request $request)
    {
        $request->validate([
            'id_medico'   => 'required|string'
        ]);
        $id_medico = $request->id_medico;
        $estado = StatusAppointment::where('estado_cita','confirmada')->value('id');
        $appointment = Appointment::where('dispo.id_persona','=',$id_medico)
        ->where('citas.estado','=',$estado)
        ->where('dispo.horaInicio','>',Carbon::now())
        ->join('disponibilidadhoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
        ->join('personas','personas.id','citas.id_persona')
        ->select('personas.id AS id_paciente','citas.id_cita AS id',
        'personas.nombre AS nombre_paciente','personas.apellido AS apellido_paciente',
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

    public function verAntecedenteID($id)
    {
        $antecedente = MedicalHistory::where('paciente',$id)
        ->select('alergias','enfermedades','enfermedades_familiares','cirugias','medicamentos','otros','paciente')
        ->get();
        $paciente= User::where('id',$id)
        ->join('tipo_documento','tipo_documento.documento','personas.tipo_documento')
        ->select('tipo_documento.nombre_documento AS tipo_documento','personas.numero_documento AS numero_documento',
        'personas.nombre AS nombre','personas.apellido AS apellido')
        ->get();
        return response()->json([
            'paciente' => $paciente,
            'antecedente' => $antecedente
            ]);
    }

    public function guardarAntecedenteId(Request $request)
    {
        $paciente=$request->paciente;
        $antecedente = MedicalHistory::where('paciente',$paciente)
        ->get();

        if (count($antecedente)==0) {
            MedicalHistory::create($request->all());
            return response()->json([
                'message' => 'Se ha guardado el antecedente correctamente',
            ]);
        }else {
            MedicalHistory::where('paciente',$paciente)
            ->update($request->all());
            return response()->json([
                'message' => 'Se ha actualizado el antecedente correctamente',
            ]);
        }
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


    public function cargarOdonto($id)
    {
        $odonto = Diagnosis::where('odontograma',$id)
        ->join('sintomas','sintomas.id','diagnostico.sintomas')
        ->join('dientes','dientes.numero','diagnostico.diente')
        ->select('dientes.arcada AS arcada','diagnostico.diente AS diente','diagnostico.superficie AS superficie',
                'sintomas.nombre_sintoma AS nombre_sintoma','sintomas.color AS color')
        ->get();
        return \response()->json($odonto);
    }

    public function getDientes()
    {
        $dientes = Dent::all();
        return \response()->json($dientes);
    }

    public function getSintomas()
    {
        $sintomas = Symptom::all();
        return \response()->json($sintomas);
    }

    public function getTratamientos()
    {
        $tratamientos = Treatment::all();
        return \response()->json($tratamientos);
    }

    public function guardarDiagnostico(Request $request)
    {
        $diagnosticos = $request->all();
        foreach ($diagnosticos as $diagnostico) {
            Diagnosis::create($diagnostico);
        }
        return response()->json([
            'message' => 'Se ha guardado satisfactoriamente',
        ]);
    }

    public function getDiente(Request $request)
    {
        $diente = Diagnosis::where('diente',$request->diente)
        ->where('odontograma',$request->odontograma)
        ->join('sintomas','sintomas.id','diagnostico.sintomas')
        ->join('tratamiento','tratamiento.id','diagnostico.tratamiento')
        ->select('diagnostico.diente AS diente','sintomas.nombre_sintoma AS sintoma',
                'diagnostico.observacion AS observacion','tratamiento.nombre_tratamiento AS tratamiento')
        ->get();

        return response()->json($diente);
    }

    public function asistencia($id)
    {
        $estado = StatusAppointment::where('estado_cita','asistida')->value('id');
        Appointment::where('id_cita',$id)
        ->update([
            'estado' => $estado
        ]);

        return response()->json([
            'message' => 'Asistencia confirmada'
        ]);
    }

    public function getDiagnosticos($id)
    {
        $odontos = Odontogram::where('ficha_dental.paciente',$id)
        ->join('ficha_dental','ficha_dental.id','odontograma.ficha')
        ->select('odontograma.id AS id','odontograma.created_at AS fecha_creacion')
        ->get();

        foreach ($odontos as $odonto => $value) {
            $diagnostico = Diagnosis::where('odontograma',$value->id)->get();
            if (count($diagnostico)==0) {
                unset($odontos[$odonto]);
            }
        }

        return response()->json($odontos);
    }

    public function diagnosticoId($id)
    {
        $diagnosticos = Diagnosis::where('odontograma',$id)
        ->get();
        return response()->json($diagnosticos);
    }


    public function getPacienteByOdonto($id)
    {
        $paciente = Odontogram::where('odontograma.id',$id)
        ->join('ficha_dental','odontograma.ficha','ficha_dental.id')
        ->join('personas','ficha_dental.paciente','personas.id')
        ->select('personas.nombre AS nombre','personas.apellido AS apellido')
        ->get();

        return response()->json($paciente);
    }

    public function nuevoDiagnostico(Request $request)
    {
        $ficha = Token::create([
            'paciente' => $request->id
        ]);
        $odonto = Odontogram::create([
            'ficha' => $ficha->id
        ]);

        return response()->json($odonto->id);
    }

    public function editDiagnostico(Request $request)
    {
        $diagnosticos = $request->all();

    foreach ($diagnosticos as $diagnostico) {
        Diagnosis::where('id',$diagnostico['id'])
        ->where('odontograma',$diagnostico['odontograma'])
        ->update([
            'diente' => $diagnostico['diente'],
            'superficie' => $diagnostico['superficie'],
            'sintomas' => $diagnostico['sintomas'],
            'observacion' => $diagnostico['observacion'],
            'tratamiento' => $diagnostico['tratamiento'],
            'valor_tratamiento' => $diagnostico['valor_tratamiento'],
        ]);
    }

        return response()->json([
            'message' => 'Se actaulizado el diagnostico correctamente'
        ]);
    }

    public function doctorDash($id)
    {
        $appointment = Appointment::join('disponibilidadhoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
        ->join('estado_cita','estado_cita.id','citas.estado')
        ->where(
            [
                'dispo.id_persona' => $id,
                'estado_cita.estado_cita' => 'confirmada'
            ]
        )
        ->get();
        return response()->json([
            'asignadas' => count($appointment)
        ]);
    }
}
