<?php

use Illuminate\Support\Facades\Route;
use pp\Http\Controllers\UsuarioController;
use App\Http\Controllers\UpController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\OrigenRecursoController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
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

if (Auth::check()) {
    return redirect('/Inicio');
}
Route::resource('/usuario', UsuarioController::class)->middleware('rol:ti,admin,alm');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::view('/', 'Login.inicio2')->name('usuario.login')->middleware('guest');
Route::view('/inicio', 'inicio')->name('inicio')->middleware('rol:ti,admin,alm,user');
Route::get('getArticulo', [ArticuloController::class, 'getArticulo'])->name('articulo.get');
Route::get('/articulo/pdf', [ArticuloController::class, 'pdf'])->name('articulo.pdf');

Route::resource('/up', UpController::class)->middleware("auth:sanctum");
Route::resource('/area', AreaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/departamento', DepartamentoController::class)->middleware('rol:ti,admin,alm');
Route::resource('/partida', PartidaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/articulo', ArticuloController::class)->middleware('rol:ti,admin,alm');
Route::resource('/proveedor', ProveedorController::class)->middleware('rol:ti,admin,alm');
Route::resource('/recurso', OrigenRecursoController::class)->middleware('rol:ti,admin,alm');
Route::resource('/unidadesmedicion', UnidadMedidaController::class)->middleware('rol:ti,admin,alm');

Route::resource('/factura', FacturaController::class)->middleware('rol:ti,admin,alm');








