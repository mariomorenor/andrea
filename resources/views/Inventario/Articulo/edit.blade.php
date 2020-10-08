@extends('layouts.Inventario')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Inventario/Articulo/editar_articulo.css') }}">
@endpush

@section('panel')
    <h2 class="font-weight-bold text-center">Actualización de Artículo</h2>
    <form action="{{ route('productos.update', ['producto'=>$product->id]) }}" class=" col-10 mx-auto form_producto " method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Código:</label>
                    <input autocomplete="off" readonly type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                        placeholder="PR-001" value="{{old('code') ?? $product->code}}">
                    @error('code')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="font-weight-bold">Efectivo:</label>
                    <input autocomplete="off" type="number" class="form-control @error('cash') is-invalid @enderror" name="cash"
                        placeholder="0.01" value="{{old('cash') ?? $product->prices[0]->value}}">
                    @error('cash')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Nombre:</label>
                    <input autocomplete="off" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        placeholder="Nombre del Producto" value="{{old('name') ?? $product->name}}">
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="font-weight-bold">Promoción:</label>
                    <input autocomplete="off" type="number" class="form-control @error('promo') is-invalid @enderror" name="promo"
                        placeholder="0.01" value="{{old('promo') ?? $product->prices[1]->value}}">
                    @error('promo')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Precio:</label>
                    <input autocomplete="off" type="number" step="0.01" min="0.01" max="9999"
                        class="form-control @error('price') is-invalid @enderror" name="price" placeholder="0.01" value="{{old('price') ?? $product->price}}">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="" class="font-weight-bold">Crédito:</label>
                    <input autocomplete="off" type="number" class="form-control @error('credit') is-invalid @enderror" name="credit"
                        placeholder="0.01" value="{{old('credit') ?? $product->prices[2]->value}}">
                    @error('credit')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="" class="font-weight-bold">Descripción:</label>
                <textarea name="description" id="description" cols="30" rows="5"
                    class="form-control form_producto__textarea @error('description') is-invalid @enderror">{{old('description') ?? $product->description}}</textarea>
                @error('description')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-success btn-lg">ACTUALIZAR<i
                        class="far fa-save fa-lg ml-2"></i></button>
                <a href="{{ route('listar_articulos') }}" class="btn btn-secondary btn-lg">CANCELAR<i class="fas fa-arrow-circle-left ml-2"></i></a>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script>
           $('#menu_inventario__listar_articulo').addClass('menu_inventario__item--active');
    </script>
@endpush