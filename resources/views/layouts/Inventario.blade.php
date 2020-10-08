@extends('layouts.app')

@prepend('css')
    <link rel="stylesheet" href="{{ asset('css/Inventario/main_inventario.css') }}">
@endprepend

@section('content')
    <div class="aside">
        
        <ul class="menu_inventario">
            <h4 class="text-white font-weight-bold text-center menu_inventario__item--title">Productos</h4>
            <li class="menu_inventario__item" id="menu_inventario__listar_articulo">
                <a class="menu_inventario__link" href="{{ route('listar_articulos') }}">Listar Artículos</a>
            </li>
            <li class="menu_inventario__item" id="menu_inventario__crear_articulo">
                <a class="menu_inventario__link" href="{{ route('crear_articulo') }}">Crear Artículo</a>
            </li>
            <li class="menu_inventario__item" id="menu_inventario__stock" >
                <a class="menu_inventario__link" href="{{ route('stock') }}">Entradas</a>
            </li>
        </ul>
    </div>
    <div class="panel px-5">
        @yield('panel')
    </div>
@endsection