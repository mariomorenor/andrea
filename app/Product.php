<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
 
    
    protected $fillable=[
        'code','name','description','price'
    ];
    
    protected $with=['prices.payment_method','stock'];

    public function prices()
    {
        return $this->hasMany(Price::class,'product_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class,'product_id');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock','>',0);
    }

}
