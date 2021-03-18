<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $table = 'antecedentes_medicos';
    protected $fillable = [
        'alergias','enfermedades','enfermedades_familiares','cirugias','medicamentos','otros','paciente'
    ];
}
