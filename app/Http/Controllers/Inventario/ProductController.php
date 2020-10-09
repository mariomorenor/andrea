<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Price;
use App\Product;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
       $products = Product::all();
    // $products = Product::with(['prices','stock'=>function($query){
    //     $query->where('total','>',0)->get();
    // }])->get();
        return response()->json([
            'rows'=>$products
        ]);
    }

    public function list_products(Request $request)
    {
        $products = Product::with(['prices','stock'=>function($query){
            $query->where('total','>',0)->get();
        }])->get();
        $products = collect($products)->where('stock','!=',null);
        return response()->json([
            'rows'=>$products
        ]);
    }

    public function store(ProductRequest $request)
    {
        DB::transaction(function() use($request){
            
            $product = new Product;
            $product->fill($request->all());
            $product->save();
            
            Price::create([
                    'product_id'=>$product->id,
                    'payment_method'=>1, //1 Efectivo
                    'value'=>$request->cash
            ]);
            Price::create([
                'product_id'=>$product->id,
                'payment_method'=>2, //2 Promoción
                'value'=>$request->promo
            ]);
            Price::create([
                'product_id'=>$product->id,
                'payment_method'=>3, //3 Crédito
                'value'=>$request->credit
            ]);

        });

        return redirect()->route('listar_articulos')->with('status','success');
        
    }

    public function edit(Product $producto)
    {
    
        return view('Inventario.Articulo.edit')->with(['product'=>$producto]);
    }
    
    public function update(ProductRequest $request, Product $producto)
    {
      DB::transaction(function() use($request,$producto){
            $producto->fill($request->all());
            $producto->save();
            $prices = Price::where('product_id',$producto->id)->orderBy('payment_method','asc')->get();
            $prices[0]->update([
                'value'=> $request->cash
            ]); 
            $prices[1]->update([
                'value'=> $request->promo
            ]); 
            $prices[2]->update([
                'value'=> $request->credit
            ]); 
          
        });

        return redirect()->route('listar_articulos')->with('status','success');
    }

    public function show(Request $request, Product $producto)
    {
        if ($request->ajax()) {
            return $producto;
        }
        return view('Inventario.Articulo.delete')->with(['product'=>$producto]);
    }

    public function destroy(Product $producto)
    {
        $producto->delete();
        return redirect()->route('listar_articulos')->with('status','success');
    }

    public function delete_multiple_products(Request $request)
    {
        if ($request->ajax()) {
            DB::transaction(function() use($request){
                for ($i=0; $i < count($request->ids) ; $i++) { 
                    $product = Product::find($request->ids[$i]);
                    $product->delete();
                }
            });
        }
        return response('ok',200);
    }

}
