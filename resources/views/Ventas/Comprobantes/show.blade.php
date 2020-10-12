@extends('layouts.Ventas')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Ventas/Comprobantes/show.css') }}">
@endpush

@section('panel')
<div class="container">
    <div class="comprobante">
        <h2 class="font-weight-bold">Comprobante #<span class="text-danger">{{str_pad($invoice->code,6,"0",STR_PAD_LEFT)}}</span><span class="font-weight-normal text-muted ml-4" style="font-size: 20px">{{$invoice->status}}</span></h2>
        <h4 class="text-muted mt-3 font-weight-bold border-bottom">Datos Cliente</h4>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Nombre:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->name}}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Apellido:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->last_name}}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Cédula:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->cedula}}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Teléfono:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->phone}}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Ruc:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->ruc}}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Correo:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->email}}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Dirección:</label>
                    <input type="text" class="form-control" value="{{$invoice->cliente->address}}" readonly>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Fecha Venta:</label>
                    <input type="date" class="form-control" value="{{Carbon\Carbon::parse($invoice->date_sale)->toDateString()}}" readonly>
                </div>
            </div>
        </div>
        <h4 class="text-muted font-weight-bold border-bottom">Resumen Venta</h4>
        <div class="row">
            <div class="col">
                <div class="toolbar d-flex">
                    <label class="font-weight-bold mr-2" for="">Forma Pago:</label>
                    <h4><span class="badge badge-primary">{{ucfirst($payment->type)}}</span></h4>
                    <label class="font-weight-bold mx-2" for="">Total Factura:</label>
                    <h4><span class="badge badge-secondary">$ {{$invoice->total}}</span></h4>
                    <label class="font-weight-bold mx-2" for="">Estado:</label>
                    @if ($payment->type == 'efectivo')
                    <h4><span class="badge badge-success">Pagada</span></h4>
                    {{-- //TODO agregar lo que haga falta para ver si está pendiente o no la factura --}}
                    @elseif($payment->type == 'crédito')
                    <h4><span class="badge badge-danger">Pendiente</span></h4>
                    @endif
                </div>
                
                <table id="table_resume_products" data-toolbar=".toolbar"  data-height="500" data-url="{{ route('invoice_detail', ['invoice'=>$invoice]) }}">
                    <thead>
                        <tr>
                            <th data-field="code" data-formatter="codeFormatter">Código</th>
                            <th data-field="product" data-formatter="productFormatter">Producto</th>
                            <th data-field="quantity" data-align="center">Cantidad</th>
                            <th data-field="price" data-align="center" data-formatter="priceFormatter">V. unit</th>
                            <th data-field="total" data-align="center" data-formatter="totalFormatter">Total</th>
                            <th data-field="acciones" data-width="1" data-formatter="accionesFormatter"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <br>
    <br>
</div>
@endsection

@push('js')
    <script>
        var $table_resume_products = $('#table_resume_products');
        $table_resume_products.bootstrapTable();

        function productFormatter(value, row){
            return row.product.name;
        }
        function codeFormatter(value, row){
            return row.product.code
        }

        function priceFormatter(value){
            return `$ ${value}`;
        }
        function totalFormatter(value){
            return `$ ${value}`;
        }

        function accionesFormatter(value, row){
            console.log(row);
            return `<a title="Ver Producto" href="/productos/${row.product_id}/edit" class="btn btn-sm btn-outline-primary shadow"><i class="far fa-eye"></i></i></a>`;
        }
    </script>
@endpush