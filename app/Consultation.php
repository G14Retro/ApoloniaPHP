<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'tipo_consulta';
    protected $fillable = [
        'nombre_consulta',
    ];
}
