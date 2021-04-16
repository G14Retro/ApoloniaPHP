<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    protected $table = 'consultorios';
    protected $fillable = [
        'id_consultorio',
        'nombre_consultorio',
    ];
}
