<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    protected $table = 'odontograma';
    protected $fillable = ['odontograma','comentario','ficha'];
}
