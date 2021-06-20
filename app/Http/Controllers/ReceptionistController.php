<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Availability;
use App\Appointment;
use App\MedicalHistory;
use App\User;
use App\Surgery;
use App\Consultation;
use App\StatusAvailability;
use Carbon\Carbon;
use App\TypeDocument;
use App\StatusAppointment;
use Illuminate\Support\Facades\DB;

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
        $doctors = User::where('tipo_usuario','=',3) ->select('id','nombre','apellido') ->get();
        return response()->json($doctors);
    }

    public function verConsultorios()
    {
        $consultorios = Surgery::select('id_consultorio','nombre_consultorio')->get();
        return response()->json($consultorios);
    }

    public function verConsultas()
    {
        $consultas = Consultation::select('id_consulta',
        'nombre_consulta')->get();
        return response()->json($consultas);
    }


    public function verDisponibilidades()
    {
        $disponibilidades = StatusAvailability::select('idEstado',
        'nombreEstado')->get();
        return response()->json($disponibilidades);
    }


    public function createDispo(Request $request)
    {
        $crearDispo = Availability::create($request->all());
        return response()->json(['message' => 'El registro se ha guardado satisfactoriamente'], 201);
    }

    public function dispo(Request $request)
    {
        $dispo = Availability::find($request->all());
        return response()->json($dispo);
    }

    public function editDispo(Request $request,$id)
    {
        $dispo = Availability::find($id);
        $dispo->update($request->all());
        return response()->json('Registro Actualizado');
    }

    public function destroy($id)
    {
        $dispo = Availability::find($id);
        $dispo->delete();
        return response()->json('Registro Eliminado');
    }

    public function cita()
    {
        $citas = Appointment::join('estado_cita','estado_cita.id','citas.estado')
        ->join('disponibilidadHoraria AS dispo', 'dispo.id_disponibilidad', 'citas.disponibilidad')
        ->join('personas', 'personas.id', 'dispo.id_persona')
        ->join('tipo_consulta', 'tipo_consulta.id_consulta', 'dispo.tipo_consulta')
        ->select('citas.id_cita AS id', 'personas.nombre AS nombre', 'personas.apellido AS apellido',
                'tipo_consulta.nombre_consulta AS consulta', 'dispo.horaInicio AS fechaInicio',
                'estado_cita.estado_cita AS estado')
        ->get();
        return response()->json($citas);
    }

    public function getDispo(){
        $dispo = Availability::all();
        return response()->json($dispo);
    }

    public function tipoConsulta(){
        $tipoconsulta = Surgery::select('id_consultorio','nombre_consultorio')->get();
        return response()->json($tipoconsulta);
    }

    public function verPacientes(){
        $pacientes = User::where('tipo_usuario','=',2) -> select('id','numero_documento', 'nombre', 'apellido') ->get();
        return response()->json($pacientes);
    }

    public function buscarPaciente($id)
    {
        $paciente = User::where('numero_documento',$id)
        ->select('id','nombre','apellido')
        ->get();
        return response()->json($paciente);
    }

    public function llamarFechas($id)
    {
        $fechas = Availability::where('tipo_consulta',$id)
        ->where('estado',1)
        ->select('id_disponibilidad AS id','horaInicio')
        ->get();

        return response()->json($fechas);
    }

    public function guardarCita(Request $request)
    {
        $estado = StatusAppointment::where('estado_cita','asignada')->value('id');
        Appointment::create([
            'estado' => $estado,
            'disponibilidad' => $request->disponibilidad,
            'id_persona' => $request->id_persona,
        ]);

        return response()->json([
            'message' => 'Se ha agendado la cita correctamente'
        ]);
    }

    public function buscarCitaId($id)
    {
        $cita = Appointment::where('id_cita',$id)
        ->join('personas','personas.id','citas.id_persona')
        ->select('citas.estado AS estado','citas.disponibilidad AS disponibilidad','personas.nombre AS nombre',
                'personas.apellido AS apellido','citas.id_persona')
        ->get();
        return response()->json($cita);
    }

    public function estadoCitas()
    {
        $estados = StatusAppointment::select('estado_cita','id')->get();
        return response()->json($estados);
    }

    public function editarCita(Request $request,$id)
    {
        Appointment::findOrfail($id)->update($request->all());

        return response()->json([
            'message' => 'Se ha actualizado la cita correctamente'
        ]);
    }

    public function recepDash()
    {
        $tipo_asignada = DB::table('estado_cita')->where('estado_cita','asignada')->value('id');
        $tipo_asistida = DB::table('estado_cita')->where('estado_cita','asistida')->value('id');
        $tipo_cancelada = DB::table('estado_cita')->where('estado_cita','cancelada')->value('id');
        $estado_disponible = DB::table('estadodispo')->where('nombreEstado','disponible')->value('idEstado');
        $asignadas = Appointment::where('estado',$tipo_asignada)->get();
        $asistidas = Appointment::where('estado',$tipo_asistida)->get();
        $canceladas = Appointment::where('estado',$tipo_cancelada)->get();
        $disponibilidades = Availability::where('estado',$estado_disponible)->get();

        return response()->json([
            'asignadas' => count($asignadas),
            'asistidas' => count($asistidas),
            'canceladas' => count($canceladas),
            'disponibilidades' => count($disponibilidades),
        ]);
    }
}
