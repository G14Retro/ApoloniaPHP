<?php

namespace App\Http\Controllers;

use App\User;
use App\Consultation;
use App\Availability;
use App\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\StatusAppointment;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function dispoHorario(Request $request)
    {
        $date = Carbon::now();
        $availability = Availability::where('disponibilidadhoraria.estado','=','1')
        ->where('horaInicio','>',$date)
        ->join('personas','personas.id','disponibilidadhoraria.id_persona')
        ->join('estadoDispo','estadoDispo.idEstado','disponibilidadhoraria.estado')
        ->join('tipo_consulta','tipo_consulta.id_consulta','disponibilidadhoraria.tipo_consulta')
        ->join('consultorios','consultorios.id_consultorio','disponibilidadhoraria.consultorio')
        ->select('disponibilidadhoraria.id_disponibilidad AS Id','disponibilidadhoraria.horaInicio AS fechaIni',
                'disponibilidadhoraria.horaFinal AS fechaFin','personas.nombre AS nMedico','personas.apellido AS aMedico',
                'estadoDispo.nombreEstado AS estado','tipo_consulta.nombre_consulta AS especialidad',
                'consultorios.nombre_consultorio AS consultorio')
        ->get();
        if (count($availability)==0) {
            return response()->json(
                [
                    'Message' => 'No hay citas disponibles',
                ]
            );
        }
        return response()->json(
            $availability
        );

    }

    public function historial(Request $request)
    {
        $id_paciente = $request->id_paciente;

    $history = Appointment::where('citas.id_persona','=',$id_paciente)
    ->join('estado_cita','estado_cita.id','citas.estado')
    ->join('disponibilidadHoraria AS dispo','dispo.id_disponibilidad','citas.disponibilidad')
    ->select('citas.id_cita AS id_cita','dispo.horaInicio AS fecha_inicio','dispo.horaFinal AS fecha_fin','estado_cita.estado_cita AS estado',
    'citas.created_at AS fecha_asignacion')
    ->get();

    if (count($history)==0) {
        return response()->json(
            [
                'Message' => 'Usted no ha tomado ninguna cita',
            ]
        );
    }

    return response()->json(
        $history
    );
    }

    public function actualizarInformacion(Request $request )
    {
        $user = User::where(['id' => $request->id])
        ->update(['correo' => $request->correo,'telefono'=>$request->telefono,
                'direccion' => $request->direccion,'ciudad'=>$request->ciudad,'password' => bcrypt($request->password),
                'updated_at' => now()]);

        return response()->json([
            'Message' => 'Usuario actualizado correctamente!',
        ]);
    }
    public function agendarCita (Request $request)
    {
        $request->validate([
            "disponibilidad" => 'required | string',
            "id_paciente" => 'required | string'

        ], [
            'disponibilidad.unique' => 'El error esta en la disponibilidad',
            'id_paciente.required' => 'El error esta en el paciente'
        ]);
        $estado = StatusAppointment::where('estado_cita','asignada')->value('id');
        $cita = new Appointment ([
            'estado' => $estado,
            'disponibilidad'=> $request-> disponibilidad,
            'id_persona' => $request-> id_paciente
        ]);
        $cita->save();
        return response () -> json ([
            'Message' => 'Su cita fue agendada correctamente'
        ]);
    }

    public function dispoID(Request $request)
    {
       $idDispo = Appointment::find($request->id)->value('disponibilidad');
       $dispo = Availability::where('disponibilidadhoraria.id_disponibilidad','=',$idDispo)
       ->join('personas','personas.id','disponibilidadhoraria.id_persona')
       ->join('tipo_consulta','tipo_consulta.id_consulta','disponibilidadhoraria.tipo_consulta')
       ->join('consultorios','consultorios.id_consultorio','disponibilidadhoraria.consultorio')
       ->select('disponibilidadhoraria.id_disponibilidad AS id_dispo',
                'personas.nombre AS nombre_medico','personas.apellido AS apellido_medico',
                'disponibilidadhoraria.horaInicio AS inicio_cita','disponibilidadhoraria.horaFinal AS fin_cita',
                'tipo_consulta.nombre_consulta AS tipo_consulta','consultorios.nombre_consultorio AS consultorio')
        ->get();
       return response()->json($dispo);
    }

    public function cancelarCita($id)
    {
        $cita = Appointment::findOrfail($id);
        $estado = StatusAppointment::where('estado_cita','cancelada')->value('id');
        $cita->update([
            'estado' => $estado,
        ]
        );
        return response()->json([
            'message' => 'Se ha cancelado su cita satisfactoriamente'
        ]);
    }

    public function pacienteDash($id)
    {
        $tipo_asignada = DB::table('estado_cita')->where('estado_cita','asignada')->value('id');
        $tipo_asistida = DB::table('estado_cita')->where('estado_cita','asistida')->value('id');
        $tipo_cancelada = DB::table('estado_cita')->where('estado_cita','cancelada')->value('id');
        $estado_disponible = DB::table('estadodispo')->where('nombreEstado','disponible')->value('idEstado');
        $asignadas = Appointment::where([
            'estado' => $tipo_asignada,
            'id_persona' => $id
        ])->get();
        $asistidas = Appointment::where([
            'estado' => $tipo_asistida,
            'id_persona' => $id
        ])->get();
        $canceladas = Appointment::where([
            'estado' => $tipo_cancelada,
            'id_persona' => $id
        ])->get();

        return response()->json([
            'asignadas' => count($asignadas),
            'asistidas' => count($asistidas),
            'canceladas' => count($canceladas),
        ]);
    }
}
