<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'tipo_usuario';
    protected $primary = 'id_tipo';
    protected $fillable = ['nombre_tipo_usuario','id_tipo'];
}
