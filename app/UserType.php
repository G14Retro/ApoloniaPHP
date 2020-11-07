<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'tipo_usuario';
    protected $fillable = ['nombre_tipo_usuario',];
}
