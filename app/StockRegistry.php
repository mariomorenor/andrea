<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockRegistry extends Model
{
    protected $fillable=[
        'quantity',
        'product_id',
        'date',
        'balance'
    ];

    protected $casts=[
        'date'=>'date',
        'quantity'=>'integer',
        'product_id'=>'integer',
        'balance'=>'integer'
    ];
}
