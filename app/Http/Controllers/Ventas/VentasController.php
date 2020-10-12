<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceBody;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function index()
    {   
        // return    $invoice = Invoice::find(2);
        return view('layouts.Ventas');
    }

    public function nueva_venta()
    {
        return view('Ventas.Nueva_Venta');
    }

    public function comprobantes()
    {
        return view('Ventas.Comprobantes');
    }
}
