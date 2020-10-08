@extends('layouts.Inventario')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Inventario/Articulo/eliminar_articulo.css') }}">
@endpush

@section('panel')
<div class="container">

    <h1>Eliminar Producto</h1>
    <p>¿Está seguro de eliminar el producto?</p>
    <div class="row">
        <div class="container_producto">
            <div class="row">
                <div class="col">            
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Código:</label>
                        <input readonly type="text" class="form-control" value="{{$product->code ?? ''}}">
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Precio:</label>
                        <input readonly type="text" class="form-control" value="{{$product->price ?? ''}}">
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Efectivo:</label>
                        <input readonly type="text" class="form-control" value="{{$product->prices[0]->value ?? ''}}">
                    </div>

                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Nombre:</label>
                        <input readonly type="text" class="form-control" value="{{$product->name ?? ''}}">
                    </div>

                    <div class="form-group">
                        <label for="" class="font-weight-bold">Promoción:</label>
                        <input readonly type="text" class="form-control" value="{{$product->prices[1]->value ?? ''}}">
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Crédito:</label>
                        <input readonly type="text" class="form-control" value="{{$product->prices[2]->value ?? ''}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="font-weight-bold">Descripción:</label>
                <textarea readonly name="description" id="" class="form-control container_producto__textarea" cols="30" rows="10">{{$product->description ?? ''}}</textarea>
            </div>
            <div class="row">
                <div class="col">
                    <form action="{{ route('productos.destroy', ['producto'=>$product]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg shadow">ELIMINAR <i class="fas fa-trash-alt"></i></button>
                        <a href="{{ route('listar_articulos') }}" class="btn btn-secondary btn-lg shadow">CANCELAR<i class="fas fa-arrow-circle-left ml-2"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
           $('#menu_inventario__listar_articulo').addClass('menu_inventario__item--active');
    </script>
@endpush