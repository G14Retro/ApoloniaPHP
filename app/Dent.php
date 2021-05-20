<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dent extends Model
{
    protected $table = 'dientes';
    protected $primary = 'numero';
    protected $fillable = [
        'numero','nombre','arcada'
    ];
    public $timestamps = false;
}
