<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'estadoDispo';
    protected $fillable = [
        'idEstado',
        'nombreEstado',
    ];
}
