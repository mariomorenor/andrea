<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumeInvoice extends Model
{
    protected $fillable=[
        'code',
        'date_sale',
        'payment_method_id',
        'client_id',
        'total'
    ];

    protected $casts=[
        'code'=>'integer',
        'date_sale'=>'date',
        'payment_method_id'=>'integer',
        'total'=>'double'
    ];
}
