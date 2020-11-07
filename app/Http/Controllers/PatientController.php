<?php

namespace App\Http\Controllers;

use App\User;
use App\Consultation;
use App\Availability;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function dispoHorario(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);
        
        $availability = Availability::where('horaInicio','>=',$request->fecha)
        ->where('disponibilidadhoraria.estado','=','1')
        ->join('personas','personas.id','disponibilidadhoraria.id_persona')
        ->join('estadoDispo','estadoDispo.idEstado','disponibilidadhoraria.estado')
        ->join('tipo_consulta','tipo_consulta.id_consulta','disponibilidadhoraria.tipo_consulta')
        ->join('consultorios','consultorios.id_consultorio','disponibilidadhoraria.consultorio')
        ->select('disponibilidadhoraria.horaInicio AS Hora inicio',
                 'disponibilidadhoraria.horaFinal AS Hora final','personas.nombre AS Nombre Medico','personas.apellido AS Apellido Medico',
                 'estadoDispo.nombreEstado AS Estado','tipo_consulta.nombre_consulta AS Especialidad',
                 'consultorios.nombre_consultorio AS Consultorio')
        ->get();
        if (count($availability)==0) {
            return response()->json(
                [
                    'Message' => 'No hay citas disponibles para el día seleccionado',
                ]
               );
        }
         return response()->json(
            $availability
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
}
