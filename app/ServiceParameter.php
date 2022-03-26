<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceParameter extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'key',
        'value'
    ];
}
