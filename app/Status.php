<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'estado';
    protected $fillable = ['idEstado','nombreEstado'];
}
