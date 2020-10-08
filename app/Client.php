<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'name',
        'last_name',
        'cedula',
        'address',
        'phone',
        'email'
    ];

    protected $casts=[
        'phone'=>'integer',
        'cedula'=>'integer'
    ];
}
