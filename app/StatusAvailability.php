<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusAvailability extends Model
{
    protected $table = 'estadodispo';
    protected $fillable = ['idEstado','nombreEstado'];
}
