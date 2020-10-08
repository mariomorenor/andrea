<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable=[
        'total',
        'product_id',
        
    ];

    protected $casts=[
        'total'=>'integer',
        'product_id'=>'integer'
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'product_id');
    }
}
