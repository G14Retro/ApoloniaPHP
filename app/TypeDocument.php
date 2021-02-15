<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    protected $table = 'tipo_documento';
    protected $fillable = ['documento','nombre_documento',];
}
