<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'tratamiento';
    protected $fillable = ['nombre_tratamiento','valor_tratamiento'];
}
