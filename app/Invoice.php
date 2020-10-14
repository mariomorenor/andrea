<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $fillable=[
        'code',
        'date_sale',
        'payment_method_id',
        'status'
    ];

    protected $casts=[
        'date_sale'=>'date',
        'payment_method'=>'integer',
        'code'=>'integer',
        'status'=>"string"
    ];

    protected $with=['cliente','payment_method','productos.product'];

    public function cliente()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }

    public function productos()
    {
        return $this->hasMany(InvoiceBody::class);
    }

    protected static function booted()
    {
        static::created(function($Invoice){
            DB::transaction(function() use($Invoice){
                foreach (request()->productos as $producto) {
                    $invoiceBody = new InvoiceBody;
                    $invoiceBody->product_id = $producto['id'];
                    $invoiceBody->quantity = $producto['quantity'];
                    $invoiceBody->price = $producto['price_sale'];
                    $invoiceBody->total = $producto['total_price'];
                    $invoiceBody->invoice_id = $Invoice->id;
                    $invoiceBody->save();
                }
                
            });
        });

        static::updated(function($Invoice)
        {
            
        });

    }

}
