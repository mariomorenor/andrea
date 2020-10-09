<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceBody extends Model
{

    protected $fillable=[
        'quantity',
        'price',
        'total',
        'product_id',
    ];

    protected $casts=[
        'quantity'=>'integer',
        'price'=>'double',
        'total'=>'double',
        'invoice_id'=>'integer',
        'product_id'=>'integer'
    ];

    protected static function booted()
    {
        static::created(function($invoice_body){
            DB::transaction(function() use($invoice_body){
                
                $stock_producto = Stock::where('product_id',$invoice_body->product_id)->first();
                $stock_producto->update([
                    'total'=>($stock_producto->total - $invoice_body->quantity)
                ]);

            });

        });
    }

}
