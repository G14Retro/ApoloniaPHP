<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'citas';
    protected $fillable = [
        'estado_cita','fecha_cita','disponibilidad','id_persona',
    ];
}
