<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    protected $fillable = [
        'estado','disponibilidad','id_persona',
    ];
}
