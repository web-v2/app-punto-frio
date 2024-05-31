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
    return view('auth.login');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/* Rutas Helpers */
Route::get('proveedores/validar-dni', 'App\Http\Controllers\ProveedorController@validarDni')->name('proveedores.validar_dni');
Route::get('clientes/validar-dni', 'App\Http\Controllers\ClienteController@validarDni')->name('clientes.validar_dni');
Route::get('clientes/getDataCliente', 'App\Http\Controllers\ClienteController@getDataCliente')->name('clientes.getDataCliente');
Route::put('productos/{id}/entrada', 'App\Http\Controllers\ProductoController@entrada')->name('productos.entrada');
Route::get('ventas/{id}/invoice', 'App\Http\Controllers\VentaController@invoice')->name('ventas.invoice');

/* Rutas Resource */
Route::resource('dashboard', 'App\Http\Controllers\DashboardController');
Route::resource('proveedores', 'App\Http\Controllers\ProveedorController');
Route::resource('productos', 'App\Http\Controllers\ProductoController');
Route::resource('clientes', 'App\Http\Controllers\ClienteController');
Route::resource('entradas', 'App\Http\Controllers\EntradaController');
Route::resource('salidas', 'App\Http\Controllers\SalidaController');
Route::resource('ventas', 'App\Http\Controllers\VentaController');
