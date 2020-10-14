var $table_productos = $('#table_productos');
$table_productos.bootstrapTable({
    responseHandler: function (response) {
        // console.log(response)
        return response
    }
});
var $table_resumen = $('#table_resumen');
$table_resumen.bootstrapTable();

//*********TABLA PRODUCTOS funciones
function priceFormatter(value, row, index, field) {
    return '$' + row[field];
}

function cashFormatter(value, row, index, field) {
    return '$' + row.prices[0].value;
}

function promoFormatter(value, row) {

    return '$' + row.prices[1].value;
}

function creditFormatter(value, row) {
    return '$' + row.prices[2].value;
}

function stockFormatter(value, row) {
    // console.log(row)

    // return row.stock.total == 0 ? `Sin Especificar <a class="table_productos__link" href="/inventario/stock/${row.id}">Configurar</a>` : row.stock.total;
    return row.stock.total;
}

function accionesFormatter(value, row) {
    return `<button type="button" class="btn btn-outline-danger shadow delete_button"><i class="fas fa-trash-alt"></i></button>`;
}

function customSearch(data, text) {
    let field = $('#filter_productos').val();

    return data.filter(function (row) {
        return row[field].toUpperCase().startsWith(text.toUpperCase());
    })
}

function resetTableProductos() {
    $table_productos.bootstrapTable("refresh");
    $('#cantidad_producto').val(1);
    $table_productos.bootstrapTable('resetSearch')
}

//Reiniciar tabla productos
$('#modal_productos').on('hidden.bs.modal', function (e) {
    resetTableProductos();
})


//  ****************TABLA RESUMEN*****************

var $payment_method_id = $('#select_payment_method').val();

//Funciones
function productFormatter(value, row) {
    return row.name
}

function price_saleFormatter(value, row) {
    return '$ ' + value;
}

function quantityFormatter(value, row) {
    return value + `<div class="d-flex"><button type="button" class="ml-2 btn btn-sm btn-outline-success plus shadow delete_button"><i class="fas fa-plus-square"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary shadow delete_button minus"><i class="fas fa-minus-square"></i></button></div>`;
}

function totalFormatter(value, row) {
    row.total_price = Number((row.price_sale * row.quantity).toFixed(2));
    return '$ ' + row.total_price;
}

function totalFooterFormatter(data) {
    var field = this.field;

    return 'Total $' + data.map(function (row) {
        return +row[field]
    }).reduce(function (sum, i) {
        return Number((sum + i).toFixed(2))
    }, 0)

    // // TODO A FUTURO VINCULAR CON TABLA IVA
    // let iva = Number((total * 0.12).toFixed(2));
    // let subtotal = Number(( total - iva).toFixed(2));
    // return `
    //         <div class="row table_precios">
    //             <div class="col p-0">
    //                 <label for="" class="table_precios__label">SUBTOTAL</label>
    //                 <label for="" class="table_precios__label">IVA</label>
    //                 <label for="" class="table_precios__label">TOTAL</label>
    //             </div>
    //             <div class="col p-0">
    //                 <label for="" class="table_precios__label">${subtotal}</label>
    //                 <label for="" class="table_precios__label">${iva}</label>
    //                 <label for="" class="table_precios__label">${total}</label>
    //             </div>
    //         </div>`;
}

function detailFormatter(index, row) {
    return `<p><strong>Descripción: </strong>${row.description}</p>`;
}

window.accionesEvent = {
    'click .delete_button': function (e, value, row) {
        $table_resumen.bootstrapTable('remove', {
            field: 'code',
            values: row.code
        })
    }
}

window.quantityEvent = {
    'click .plus': function (e, value, row, index) {
        row.quantity++;
        let productos_sin_stock = comprobarStock(row, true);
        if (productos_sin_stock.length > 0) {
            row.quantity--;
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'No se puede agregar más productos, fuera de Stock!'
            });
            return;
        } else {

            $table_resumen.bootstrapTable('updateRow', {
                index,
                row
            });
        }
    },
    'click .minus': function (e, value, row, index) {
        if (row.quantity > 1) {
            row.quantity--;
        }
        $table_resumen.bootstrapTable('updateRow', {
            index,
            row
        });
    }
}

///Cambio del metodo de pago 

$('#select_payment_method').change(function (e) {
            e.preventDefault();
            $payment_method_id = $('#select_payment_method').val();
            let productos = $.map($table_resumen.bootstrapTable('getData'), function (row) {
                return row
            });

            if ($('#select_payment_method').val() == 3) {
                $('#payment_efectivo').css('display', 'flex');
            } else {
                $('#payment_efectivo').css('display', 'none');

            }
                payment_method_function(productos, 1) // (1) Segundo parámetro es para actualizar 

            });

        //AGREGAR PRODUCTOS A TABLA

        $('#btn_add_products').click(function (e) {
            e.preventDefault();
            let productos = $.map($table_productos.bootstrapTable('getSelections'), function (row) {
                return row
            })
            if (productos.length > 0) {
                payment_method_function(productos, 2); //(2) Segundo parámetro es para insertar
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Seleccione al menos un artículo',
                    timer: 1300
                })
            }
        });

        //FUNCION QUE AGREGA PRODUCTOS A LA TABLA RESUMEN
        function payment_method_function(productos, accion) {
            try {

                if (accion == 1) {
                    $table_resumen.bootstrapTable("removeAll");
                } else {
                    let productos_en_factura = $.map($table_resumen.bootstrapTable('getData'), function (row) {
                        return row
                    });

                    if (check_Productos(productos, productos_en_factura)) {
                        return;
                    }
                }



                productos.forEach(producto => {

                    switch (Number($payment_method_id)) {
                        case 1:
                            producto.price_sale = producto.prices[0].value;
                            break;
                        case 2:
                            producto.price_sale = producto.prices[1].value
                            break;
                        case 3:
                            producto.price_sale = producto.prices[2].value
                            break;
                    }
                    if (accion == 2) {
                        producto.quantity = Number($('#cantidad_producto').val());
                        // COMPROBAR SI EL PRODUCTO O PROPDUCTOS SELECCIONADOS EWSTARÍAN FUERA DE STOCK
                        let productos_sin_stock = comprobarStock(productos);

                        if (productos_sin_stock.length > 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Existen Productos que están fuera de stock, compruebe antes de agregarlos a la venta'
                            });
                            return;
                        }

                    }
                    producto.total_price = Number((producto.price_sale * producto.quantity).toFixed(2));
                    $table_resumen.bootstrapTable("insertRow", {
                        index: $table_resumen.bootstrapTable("getOptions").totalRows + 1,
                        row: producto
                    })

                });


                if (accion == 2) {
                    $('.alert').addClass('show');
                    setTimeout(function () {
                        $('.alert').removeClass('show');
                    }, 3000);
                }
                resetTableProductos();

            } catch (error) {
                console.log(error)
            }


        }
        ///FIN FUNCION TOCHA PRRO


        function check_Productos(productos_seleccionados, productos_en_tabla) {
            let productos_repetidos = [];

            productos_en_tabla.map(producto => {

                return productos_seleccionados.forEach(prod => {
                    if (prod.id == producto.id) {
                        productos_repetidos.push(prod)
                    }
                });
            });
            if (productos_repetidos.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: `<p>Existen Productos que ya han sido agregados.</p>`,
                    timer: 1500
                });
                return true;
            }
            return false;
        }

        function comprobarStock(productos_seleccionados, update = false) {
            let productos_sin_stock = [];
            if (update) {
                if (productos_seleccionados.quantity > productos_seleccionados.stock.total) {
                    productos_sin_stock.push(productos_seleccionados);
                }
            } else {
                productos_seleccionados.map(producto => {
                    if (producto.quantity > producto.stock.total) {
                        productos_sin_stock.push(producto);
                    }

                });
            }

            return productos_sin_stock;

        }
