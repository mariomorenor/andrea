@extends('layouts.app')

@prepend('css')
    <link rel="stylesheet" href="{{ asset('css/Ventas/main_ventas.css') }}">
@endprepend

@section('content')
    <div class="aside">
        <ul class="menu_ventas">
            <h4 class="text-white font-weight-bold text-center menu_ventas__item--title">Ventas</h4>
            <li class="menu_ventas__item" id="menu_ventas__nueva_venta">
                <a class="menu_ventas__link" href="{{ route('nueva_venta') }}">Nueva Venta </a>
            </li>
            <li class="menu_ventas__item" id="menu_ventas__comprobantes">
                <a class="menu_ventas__link" href="#">Comprobantes</a>
            </li>
        </ul>
    </div>
    <div class="panel px-5">
        @yield('panel')
    </div>
@endsection