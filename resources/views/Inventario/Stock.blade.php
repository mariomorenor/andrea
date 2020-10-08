@extends('layouts.inventario')

@push('css')
    <link rel="stylesheet"  href="{{ asset('css/Inventario/stock.css') }}">
@endpush

@section('panel')
    <div class="container">
        <h1 class="font-weight-bold">Entrada de Inventario</h1>
        <form class="form_stock" action="{{ route('actualizar_stock') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-4">
                    <label for="" class="font-weight-bold">Código:</label>
                    <select name="code" class="form-control form_stock__select_code" id="form_stock__select_code">
                        <option value="null" selected disabled>Seleccione...</option>
                        @isset($products)
                            @foreach ($products as $product)
                                <option @if($prod->id == $product->id) selected @endif  value="{{$product->id}}">{{$product->code}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bold">Nombre Producto:</label>
                    <input readonly type="text" class="form-control" id="form_stock__input_name" value="{{$prod->name}}">
                </div>
         
            
                <div class="col-4">
                    <label for="" class="font-weight-bold">Cantidad Actual Producto:</label>
                    <input readonly name="balance" type="text" class="form-control" id="form_stock__input_quantity" value="{{$prod->stock->total ?? 'Sin Especificar'}}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <label for="" class="font-weight-bold">Cantidad Entrante:</label>
                    <input type="number" class="form-control" name="quantity" step="1" min="1" max="9999" placeholder="Escriba la cantidad del producto" required>
                </div>
                <div class="col-4">
                    <label for="" class="font-weight-bold">Fecha Ingreso:</label>
                    <input type="date" class="form-control" name="date" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-success btn-lg shadow">GUARDAR<i class="far fa-save fa-lg ml-2"></i></button>
                    <a href="{{ route('listar_articulos') }}" class="btn btn-secondary btn-lg">CANCELAR<i class="fas fa-arrow-circle-left ml-2"></i></a>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')

    <script>

        $('#menu_inventario__stock').addClass('menu_inventario__item--active');

        $('#form_stock__select_code').change(function (e) { 
            axios.get("/productos/"+$('#form_stock__select_code').val())
             .then(({data})=>{
                 $('#form_stock__input_quantity').val(data.stock.total == null ? 'Sin Especificar':data.stock.total );
                 $('#form_stock__input_name').val(data.name);
             })
             .catch((error)=>{
                 console.log(error.response)
             });
        });
    </script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon:'success',
                title: 'Operación Realizada Correctamente!',
                timer: 1300
            })
        </script>
    @endif

@endpush

