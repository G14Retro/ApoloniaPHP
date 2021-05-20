<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnostico';
    protected $fillable = ['odontograma','diente','superficie','sintomas','observacion','tratamiento','valor_tratamiento'];
    public $timestamps = false;
}
