<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusAppointment extends Model
{
    protected $table = 'estado_cita';
    protected $fillable = ['id','estado_cita'];
}
