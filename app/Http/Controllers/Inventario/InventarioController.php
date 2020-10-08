<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;

class InventarioController extends Controller
{
    public function index()
    {
      return view('layouts.Inventario');
    }

    public function listar_articulos()
    {
        return view('Inventario.Listar_Articulos');
    }
    
    public function crear_articulo()
    {
        return view('Inventario.Articulo.create');
    }

    public function stock(Product $producto)
    {
        $products = Product::all();
        return view('Inventario.Stock')->with(['prod'=>$producto,'products'=>$products]);
    }
}
