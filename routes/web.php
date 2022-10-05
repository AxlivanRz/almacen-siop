<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UpController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\OrigenRecursoController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\EncabezadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Auth\LoginController;
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


Route::resource('/usuario', UsuarioController::class)->middleware('auth');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::view('/', 'Login.inicio2')->name('usuario.login')->middleware('guest');
Route::view('/inicio', 'inicio')->name('inicio')->middleware('auth');
Route::get('getArticulo', [ArticuloController::class, 'getArticulo'])->name('articulo.get');

Route::resource('/up', UpController::class)->middleware('auth');
Route::resource('/area', AreaController::class)->middleware('auth');
Route::resource('/departamento', DepartamentoController::class)->middleware('auth');
Route::resource('/partida', PartidaController::class)->middleware('auth');
Route::resource('/articulo', ArticuloController::class)->middleware('auth');
Route::resource('/proveedor', ProveedorController::class)->middleware('auth');
Route::resource('/recurso', OrigenRecursoController::class)->middleware('auth');
Route::resource('/unidadesmedicion', UnidadMedidaController::class)->middleware('auth');
Route::resource('/encabezado', EncabezadoController::class)->middleware('auth');

Route::resource('/factura', FacturaController::class)->middleware('auth');
Route::get('/factura/form2/{id}', [FacturaController::class, 'formfactura'])->name('factura.form2');









