<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('ventas/venta','VentaController');
Route::group(['middleware' => 'usuarioAdmin'], function(){
	Route::resource('seguridad/usuario','UsuarioController');
});
Route::get('elimina', 'VentaController@eliminaTemporalVenta');
Route::get('store/{id}', 'VentaController@store');
Route::put('cantidad/{id}', 'VentaController@cantidadPro');
Route::get('/{slug?}', 'HomeController@index');
