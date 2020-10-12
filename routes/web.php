<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['register'=>false,'confirm'=>false,'verify'=>false,'reset'=>false]);

Route::middleware(['auth'])->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');
    
    
   
    

    //RUTAS STOCK
    Route::post('stock','Inventario\StockController@actualizar_stock')->name('actualizar_stock');

    //RUTAS INVENTARIO
    Route::get('inventario','Inventario\InventarioController@index');
        // --- panel Listar Articulos
    Route::get('inventario/listar-articulos','Inventario\InventarioController@listar_articulos')->name('listar_articulos');
    Route::delete('delete_products','Inventario\ProductController@delete_multiple_products');
    Route::resource('productos','Inventario\ProductController');
        // --- panel crear articulo
    Route::get('inventario/crear-articulo','Inventario\InventarioController@crear_articulo')->name('crear_articulo');
        // --- panel Entradas
    Route::get('inventario/stock/{producto?}','Inventario\InventarioController@stock')->name('stock');
    
    //RUTAS VENTAS
    Route::get('ventas','Ventas\VentasController@index');
        // --- panel Nueva Venta
    Route::get('listar_productos','Inventario\ProductController@list_products')->name('productos_disponibles');
    Route::get('ventas/nuevo','Ventas\VentasController@nueva_venta')->name('nueva_venta');
    Route::post('generar-venta','Ventas\InvoiceController@store');
        // --- panel Comprobantes
    Route::get('ventas/comprobantes','Ventas\VentasController@comprobantes')->name('comprobantes');
    Route::get('ventas/comprobantes/invoice_detail/{invoice}','Ventas\InvoiceController@get_invoice_products')->name('invoice_detail');
    Route::resource('invoices','Ventas\InvoiceController')->only(['index','show','update']);
    Route::resource('ventas/payment_methods','Ventas\PaymentMethodController')->only(['index']);

});