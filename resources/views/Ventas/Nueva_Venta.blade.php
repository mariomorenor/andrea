@extends('layouts.Ventas')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Ventas/nueva_venta.css') }}">
@endpush

@section('panel')
    <div class="container">
       <h1 class="font-weight-bold">Nueva Venta</h1>
       <form class="form_venta" id="form_venta" action="#" method="POST">
            @csrf
            <div class="row border-bottom rounded mx-1">
                <h3 class="text-muted font-weight-bold mb-0  ">Datos Cliente</h3>
                <label for="usuario_final" class="mx-3 my-auto font-weight-bold">Usuario Final</label>
                <input type="checkbox"  name="usuario_final" checked id="usuario_final">
                <div class="ml-auto">
                    <label for="" class="font-weight-bold" >Comprobante #:</label>
                    @if (App\Invoice::all()->count() == 0)
                        <label for="" id="code_factura">000001</label>
                    @else
                        <label for="" id="code_factura">{{App\Invoice::orderBy('code','desc')->first()->code + 1}}</label>
                    @endif
                </div>
            </div>
            <div class="row form_venta__datos_cliente">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Nombre:</label>
                                <input type="text" class="form-control form_venta__input_clientes " name="name" required disabled autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Teléfono:</label>
                                <input type="number" class="form-control form_venta__input_clientes" name="phone" disabled autocomplete="off">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Apellido:</label>
                                <input type="text" class="form-control form_venta__input_clientes" name="last_name" required disabled autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Ruc:</label>
                                <input type="number" class="form-control form_venta__input_clientes" name="ruc" disabled autocomplete="off">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Cédula:</label>
                                <input type="number" class="form-control form_venta__input_clientes" name="cedula" required disabled autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="">Correo:</label>
                                <input type="email" class="form-control form_venta__input_clientes" name="email" disabled autocomplete="off">
                            </div>
                        </div>
            </div>
            <div class="row form_venta__datos_cliente">
                <div class="col-8">
                    <div class="form-group">
                        <label class="font-weight-bold" for="">Dirección:</label>
                        <input type="text" class="form-control form_venta__input_clientes" name="address" disabled autocomplete="off">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Fecha:</label>
                        <input type="date" class="form-control" name="date_sale" id="date_sale" value="{{date('Y-m-d')}}" max="{{date('Y-m-d')}}"  required>
                    </div>
                </div>
            </div>
            <h3 class="text-muted font-weight-bold border-bottom rounded">Resumen Venta</h3>
            <div class="d-flex">
               <div class="mr-2">
                   <button type="button" data-toggle="modal" data-target="#modal_productos" class="btn btn-primary mb-2">Productos <i class="fas fa-plus-circle fa-lg"></i></button>
                </div>
                <label for="" class="font-weight-bold my-auto mr-2">Forma de Pago:</label>
                <select class="form-control select_payment_method" name="payment_method_id" id="select_payment_method">
                    @foreach (App\PaymentMethod::all() as $payment)
                        <option value="{{$payment->id}}">{{ucfirst($payment->type)}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col"> 
                    <table id="table_resumen" class="table_resumen" data-height="400" data-show-footer="true">
                        <thead class="bg-secondary">
                            <tr class="text-white">
                                <th data-field="acciones" data-events="accionesEvent" data-width="50" data-formatter="accionesFormatter"></th>
                                <th data-field="code">Código</th>
                                <th data-field="product" data-formatter="productFormatter">Producto</th>
                                <th data-field="quantity" data-events="quantityEvent" data-width="100" data-align="center" data-formatter="quantityFormatter">Cant.</th>
                                <th data-field="price_sale" data-formatter="price_saleFormatter" data-width="100"  data-align="center" >V. Unit.</th>
                                <th data-field="total_price" data-footer-formatter="totalFooterFormatter" data-width="50"  data-align="center" data-formatter="totalFormatter">Total</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <button type="button" id="btn_generar_venta" class="btn btn-success">GENERAR VENTA</button>
                </div>
            </div>
       </form>
       <br>
       <br>
    </div>
    <div class="modal fade" id="modal_productos">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Productos Disponibles</h5>
                </div>
                <div class="modal-body p-0">
                    <div class="toolbar">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal" >Cancelar</button>
                        <button class="btn btn-success" type="button" id="btn_add_products">Agregar</button>
                        <label for="" class="font-weight-bold">Cantidad:</label>
                        <input type="number" class="form-control toolbar__input_quantity mr-3" id="cantidad_producto" step="1" min="1" value="1" max="99" >
                        <label for="" class="font-weight-bold mr-2">Filtro: </label>
                            <select class="form-control toolbar__select_filter" name="filter_productos" id="filter_productos">
                                <option value="code">Código</option>
                                <option value="name">Nombre</option>
                            </select>
                    </div>
                    <table id="table_productos" data-toolbar=".toolbar"  data-detail-formatter="detailFormatter"  data-search-align="left"  data-detail-view="true" class="table_productos" data-click-to-select="true" data-checkbox-header="false" data-url="{{ route('productos_disponibles') }}" data-height="400" data-search="true">
                        <thead class="thead-dark">
                            <tr>
                                <th data-field="state" data-checkbox="true"></th>
                                <th data-field="id" data-visible="false"></th>
                                <th data-field="code">Código</th>
                                <th data-field="name">Producto</th>
                                <th data-field="stock"  data-align="center" data-formatter="stockFormatter">Stock</th>
                                <th data-field="cash" data-align="center" data-formatter="cashFormatter">Efectivo</th>
                                <th data-field="promo" data-align="center" data-formatter="promoFormatter">Promoción</th>
                                <th data-field="credit" data-align="center" data-formatter="creditFormatter">Crédito</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div class="alert alert-success alert-dismissible fade " role="alert">
                        Se agregaron correctamente los productos! :3
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('js/Ventas/nueva_venta.js') }}"></script>
<script>
    $('#usuario_final').change(function (e) { 
        e.preventDefault();
        if ($('#usuario_final').prop('checked') ) {
            $('.form_venta__input_clientes').attr('disabled', 'disabled');
        }else{
            $('.form_venta__input_clientes').removeAttr('disabled');
        }
    });

    $(function(){
       let code =  $('#code_factura');
        code.text(code.text().padStart(6,'0'));
    //    $('#code_factura').val(code.padStart(6,'0'));
    })

// ************* Generar Venta

$('#btn_generar_venta').click(function (e) { 
    e.preventDefault();

    let cliente = obtener_datos_factura("cliente");
    let productos = obtener_datos_factura("productos");
    let total_factura = obtener_datos_factura("total_factura")
   axios.post('/generar-venta?'+$('#form_venta').serialize(),{
       productos,
       total_factura,
       code: $('#code_factura').text()
   }).then(({data})=>{
       console.log(data);
   }).catch((error)=>{
       console.log(error.response)
   });

});

function obtener_datos_factura(variable){
    
    switch (variable) {
        case "cliente":
            return $('#form_venta').serialize();
            break;

        case "total_factura":
            //MODIFICAR PARA CUANDO SE DESEE DEVOLVER SUBTOTAL IVA ETC
        let total_factura = 0;
         $table_resumen.bootstrapTable("getData").forEach(prod => {
                total_factura += prod.total_price;
            });
            return total_factura;
            // *******
            break;

        case "productos":
            let productos = $table_resumen.bootstrapTable("getData").map(prod => {
                 return prod;
            });
        return productos;
            break;
    }
}


</script>
@endpush