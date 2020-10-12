@extends('layouts.Inventario')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/Inventario/listar_articulo.css') }}">
@endpush

@section('panel')
    <div class="container">
        <div class="toolbar">
            <button class="btn btn-danger" id="toolbar__btn_eliminar">Eliminar</button>
            <select class="form-control toolbar__select_filter" name="filter_productos" id="filter_productos">
                <option value="code">Código</option>
                <option value="name">Nombre</option>
            </select>
        </div>
        <table id="table_productos" class="table_productos" data-sortable="false" data-custom-search="customSearch" data-click-to-select="true" data-checkbox-header="true" data-url="{{ route('productos.index') }}" data-pagination="true" data-height="500" data-toolbar=".toolbar" data-search="true" data-toggle="table">
            <thead class="thead-dark">
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id" data-visible="false"></th>
                    <th data-field="code">Código</th>
                    <th data-field="name">Producto</th>
                    <th data-field="stock" data-sortable="true" data-align="center" data-formatter="stockFormatter">Stock</th>
                    <th data-field="price" data-sortable="true" data-align="center" data-formatter="priceFormatter">Costo</th>
                    <th data-field="cash" data-sortable="true" data-align="center" data-formatter="cashFormatter">Efectivo</th>
                    <th data-field="promo" data-sortable="true" data-align="center" data-formatter="promoFormatter">Promoción</th>
                    <th data-field="credit" data-sortable="true" data-align="center" data-formatter="creditFormatter">Crédito</th>
                    <th data-formatter="accionesFormatter" data-width="110"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@endsection

@push('js')
    <script>
        // SideBar

        $('#menu_inventario__listar_articulo').addClass('menu_inventario__item--active');

        //************Table
        var $table = $('#table_productos').bootstrapTable();

        function priceFormatter(value, row, index, field) {
            return '$'+ row[field];
        }
        function cashFormatter(value, row, index ,field) {
        //    if (row.prices.length > 0 ) {
        //        if (row.prices[0].payment_method.type == 'efectivo') {
        //         return '$'+ row.prices[0].value;
        //        }
        //    }
        //    return 'Sin Especificar';
        return '$'+ row.prices[0].value;
        }

        function promoFormatter(value, row) {
        //     if (row.prices.length > 0 ) {
        //        if (row.prices[1].payment_method.type == 'promoción') {
        //         return '$'+ row.prices[1].value;
        //        }
        //    }
        //    return 'Sin Especificar';
        return '$'+ row.prices[1].value;
        }
        function creditFormatter(value, row) {
        //     if (row.prices.length > 0 ) {
        //        if (row.prices[2].payment_method.type == 'crédito') {
        //         return '$'+ row.prices[2].value;
        //        }
        //    }
        //    return 'Sin Especificar';
        return '$'+ row.prices[2].value;
        }
        function stockFormatter(value, row) {
            if (row.stock.total == null ) {
                return `Sin Especificar <a class="table_productos__link" href="/inventario/stock/${row.id}">Configurar</a>` ;
            }else if (row.stock.total == 0) {
                return `Fuera de Stock! <a class="table_productos__link" href="/inventario/stock/${row.id}">Agregar</a>` ;
            }else{
                return  row.stock.total + ` <a class="table_productos__link px-2" href="/inventario/stock/${row.id}"><i class="fas fa-pencil-alt"></i></a>`;
            }
            // return row.stock.total == null ? `Sin Especificar <a class="table_productos__link" href="/inventario/stock/${row.id}">Configurar</a>` : row.stock.total + ` <a class="table_productos__link px-2" href="/inventario/stock/${row.id}"><i class="fas fa-pencil-alt"></i></a>`;
        }

        function accionesFormatter(value,row) {
            return `<a href="/productos/${row.id}/edit" class="btn btn-outline-primary shadow"><i class="far fa-edit"></i></a>
                    <a href="/productos/${row.id}" class="btn btn-outline-danger shadow"><i class="fas fa-trash-alt"></i></a>`;
        }

        function customSearch(data, text) {
            let field = $('#filter_productos').val();
            
            return data.filter(function (row){
                return row[field].toUpperCase().startsWith(text.toUpperCase());
            })
        }



        //*************

        $('#toolbar__btn_eliminar').click(function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Cuidado!',
                text: 'Está apunto de eliminar uno o varios Artículos, ¿Está Seguro?',
                showCancelButton: true,
                allowOutsideClick: false,
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, Eliminar',
                confirmButtonColor: 'red',
                cancelButtonColor: 'green'
            }).then((data) => {
                if (data.value) {
                    let ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                        return row.id;
                    })
                    if (ids.length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title:'Error!',
                            text: 'Debe Seleccionar al menos un artículo.',
                            timer:1500
                        })
                    } else {
                        axios.delete('/delete_products', {
                            params: {
                                ids
                            }
                        }).then(({data}) => {
                            $table.bootstrapTable("remove", {
                                field: 'code',
                                values: ids
                            });
                            Swal.fire({
                                icon: 'success',
                                title:'Operación Realizada Correctamente!',
                                timer:1200
                            })
                            $table.bootstrapTable("refresh");
    
                        }).catch((error) => {
                            console.log(error.response)
                        });
                    }
                }
            })
        });
        
        $('#filter_productos').change(function (e) { 
            e.preventDefault();
            
        });


    </script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Operación Realizada Correctamente!',
                timer: 1000
            });
        </script>
    @endif

@endpush


