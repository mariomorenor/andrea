@extends('layouts.Ventas')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Ventas/Comprobantes/comprobantes.css') }}">
@endpush

@section('panel')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="toolbar d-flex">
                    <label for="" class="my-auto mr-2 font-weight-bold">Desde:</label>
                    <input type="date" id="date_desde" name="date_desde" class="form-control "
                        max="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                        value="{{Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')}}">
                    <label for="" class="my-auto mx-2 font-weight-bold">Hasta:</label>
                    <input type="date" id="date_hasta" name="date_hasta" class="form-control "
                        min="{{Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')}}"
                        value="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                        max="{{Carbon\Carbon::now()->format('Y-m-d')}}">
                    <label for="" class="my-auto mx-2 font-weight-bold">Filtro</label>
                    <select name="filterBy" class="form-control" id="filterBy">
                        <option value="all">Todo</option>
                        <option value="payment_type">Tipo Pago</option>
                        <option value="status">Estado</option>
                    </select>
                    <label for="" class="my-auto mx-2 font-weight-bold">Opciones</label>
                    <select id="filterBy_options" name="filterBy_options" class="form-control">
                        <option value="all" disabled selected>Selecccione un Filtro</option>
                    </select>
                </div>
                <table id="table_invoices"  data-toolbar=".toolbar"  data-height="500"   data-filter-control="true"
                    data-search="false"  data-search-align="left" data-url="{{ route('invoices.index') }}">
                    <thead class="thead-light">
                        <tr>
                            <th data-field="code" data-filter-control="input" data-width="100" data-formatter="codeFormatter">Comprobante #</th>
                            <th data-field="client" data-filter-control="input" data-formatter="clientFormatter">Cliente</th>
                            <th data-field="date_sale" data-align="center" data-formatter="dateFormatter">Fecha</th>
                            <th data-field="state">Estado</th>
                            <th data-field="payment_method" data-align="center" data-formatter="paymentMethodFormatter">
                                Tipo Pago</th>
                            <th data-field="total" data-align="center">Total</th>
                            <th data-field="status" data-align="center" data-editable="true">Status</th>
                            <th data-field="acciones" data-events="accionesEvent" data-width="95" data-align="center"
                                data-formatter="accionesFormatter"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var $table_invoices = $('#table_invoices');
        $table_invoices.bootstrapTable();

        function clientFormatter(value, row){
          
            return row.cliente.name + " " + row.cliente.last_name ;
        }
        
        function codeFormatter(value){
            return value.toString().padStart(6,'0')
        }

        function paymentMethodFormatter(value, row){
            row.Payment = row.payment_method.type;
            return row.payment_method.type.charAt(0).toUpperCase()+row.payment_method.type.slice(1);
        }

        function dateFormatter(value,row) {
            let fecha = new Date(value);
            return fecha.toLocaleDateString();
        }

        function accionesFormatter(value, row) {
            console.log(row.id)
            let button  ;
            if (row.status == 'activo') {
                button = '<a href="#" title="Inhablitar" class="btn btn-outline-danger btn-sm shadow disable"><i class="fas fa-ban"></i></a>';
            }else{
                button = '<a href="#" title="Habilitar" class="btn btn-outline-success btn-sm shadow disable"><i class="fas fa-check-square"></i></a>'
            }
            return `<a href="/invoices/${row.id}" class="btn btn-sm btn-outline-primary shadow"><i class="fas fa-eye"></i></a>
                    ${button}`;
        }

        function customSearch(data, text) {

            let field = $('#searchBy').val();
            let desde = new Date($('#date_desde').val());
            let hasta = new Date($('#date_hasta').val());
            hasta.setDate(hasta.getDate() + 1)
            let date_sale_product ;
            switch (field) {
                case "code":
                    return data.filter(function (row) {
                        date_sale_product = new Date(row.date_sale);
                        return (row.code >= text && (date_sale_product >= desde && date_sale_product <= hasta )) ;
                    })
                    break;
                case "client":
                    return data.filter(function (row) {
                        date_sale_product = new Date(row.date_sale);
                        return (row.cliente.name).toUpperCase().startsWith(text.toUpperCase()) | (row.cliente.last_name).toUpperCase().startsWith(text.toUpperCase()) && (date_sale_product >= desde && date_sale_product <= hasta ) ;
                    })
                    break;
            }

        }

        window.accionesEvent = {
            'click .disable': function(e, value, row, index){
          
                axios.put('/invoices/'+row.id,{
                    status: row.status
                })
                     .then(({data})=>{
                         row.status = data.status;
                        $table_invoices.bootstrapTable("updateRow",{
                            index,
                            row
                        });
                     })
                     .catch((error)=>{
                         console.log(error.response)
                     });

            }
        }

        $('#searchBy').change(function (e) { 
            e.preventDefault();
            $table_invoices.bootstrapTable('resetSearch');
        });

        $('#filterBy').change(function (e) { 
            e.preventDefault();
          
            $('#filterBy_options').children().remove();
            if ($('#filterBy').val() == "payment_type") {
                axios.get('payment_methods')
                 .then(({data})=>{
                    $('#filterBy_options').append($("<option>",{ value: 'all'}).text('Todo'));
                     data.forEach(payment_method => {
                        $('#filterBy_options').append($("<option>",{
                            value: payment_method.type
                        }).text(payment_method.type.charAt(0).toUpperCase()+payment_method.type.slice(1)))
                     });
                 })
                 .catch((error)=>{
                     console.log(data)
                 });  
            }else if($('#filterBy').val() == "status"){
                $('#filterBy_options').append($('<option>',{value: 'all'}).text("Todo"))
                $('#filterBy_options').append($('<option>',{value: 'activo'}).text("Activo"))
                $('#filterBy_options').append($('<option>',{value: 'inactivo'}).text("Inactivo"))
            }else{
             
                $('#filterBy_options').append($('<option>',{value: 'all', selected:'selected', disabled:'disabled'}).text("Seleccione un Filtro"))
                    $table_invoices.bootstrapTable("destroy");
                    $table_invoices.bootstrapTable();
            }
        });

        $('#filterBy_options').change(function (e) { 
            e.preventDefault();
         
            let option = $('#filterBy_options').val();
            if($('#filterBy').val() == "status"){
               if (option == 'all') {
                $table_invoices.bootstrapTable('destroy');
                    $table_invoices.bootstrapTable();
               }else{
                   $table_invoices.bootstrapTable('filterBy', {
                       status: [option]
                   })
               }
            }else if($('#filterBy').val() == 'payment_type'){
                console.log(option+" bbbb")
                if(option == "all"){
                    $table_invoices.bootstrapTable('destroy');
                    $table_invoices.bootstrapTable();
                }else{
                    $table_invoices.bootstrapTable('filterBy', {
                        Payment:[option]     
                    }) 
                }
            }
        });
        
        $('#date_desde').change(function (e) { 
            e.preventDefault();
          
            $('#date_hasta').attr('min',$('#date_desde').val() );
            $table_invoices.bootstrapTable('refresh');

        });
        $('#date_hasta').change(function (e) {
         
            e.preventDefault();
            $('#date_desde').attr('max',$('#date_hasta').val() );
            $table_invoices.bootstrapTable('refresh');
        });

    </script>
@endpush