<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        return view('layouts.Ventas');
    }

    public function nueva_venta()
    {
        return view('Ventas.Nueva_Venta');
    }
}
