<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'ficha_dental';
    protected $fillable = ['paciente'];
}
