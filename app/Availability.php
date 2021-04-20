<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $table = 'disponibilidadHoraria';
    protected $primaryKey = 'id_disponibilidad';
    protected $fillable = [
        'id_persona','dia','horaInicio','horaFinal','estado','tipo_consulta','consultorio',
    ];
    public $timestamps = false;
}
