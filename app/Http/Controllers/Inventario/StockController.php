<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;
use App\StockEntry;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function actualizar_stock(Request $request)
    {
        $product = Product::find($request->code);
        $stockEntry = new StockEntry();
        $stockEntry->date = $request->date;
        $stockEntry->balance = is_null($product->stock->total) == 1 ? 0: $product->stock->total ;
        $stockEntry->quantity = $request->quantity;
        $stockEntry->product_id = $product->id;
        $stockEntry->save();
        return redirect()->back()->with('status','success');
    }
}
