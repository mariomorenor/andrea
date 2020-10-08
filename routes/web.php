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
    //RUTAS PRODUCTOS
    Route::delete('delete_products','Inventario\ProductController@delete_multiple_products');
    Route::resource('productos','Inventario\ProductController');

    //RUTAS STOCK

    Route::post('stock','Inventario\StockController@actualizar_stock')->name('actualizar_stock');

    //RUTAS INVENTARIO

    Route::get('inventario','Inventario\InventarioController@index');
    Route::get('inventario/listar-articulos','Inventario\InventarioController@listar_articulos')->name('listar_articulos');
    Route::get('inventario/crear-articulo','Inventario\InventarioController@crear_articulo')->name('crear_articulo');
    Route::get('inventario/stock/{producto?}','Inventario\InventarioController@stock')->name('stock');
    
    //RUTAS VENTAS
    Route::get('ventas','Ventas\VentasController@index');
    Route::get('ventas/nuevo','Ventas\VentasController@nueva_venta')->name('nueva_venta');
});