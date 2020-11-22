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

        $availability = Availability::where('disponibilidadhoraria.estado','=','1')
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
