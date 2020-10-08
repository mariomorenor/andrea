<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable=[
        'value',
        'payment_method',
        'product_id'
    ];

    protected $casts=[
        'value'=>'double',
        'payment_method'=>'integer',
        'product_id'=>'integer',
    ];

    protected $with=['payment_method'];

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method');
    }
}
