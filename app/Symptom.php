<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $table = 'sintomas';
    protected $fillable = ['nombre_sintoma','color'];
}
