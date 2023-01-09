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
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ValeController;
use App\Http\Controllers\SurtirController;
use App\Http\Controllers\ReporteController;
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
Route::post('/', [LoginController::class, 'login']);
Route::view('/', 'Login.inicio2')->name('usuario.login')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/inicio', [SurtirController::class, 'indexS'])->name('inicio')->middleware('rol:ti,admin,alm,user');
Route::get('/vale/confirmacion', [SurtirController::class, 'indexAdmin'])->name('surtir.indexAdmin');
Route::get('/vale/confirmacion/{id}', [SurtirController::class, 'submitAlmacen'])->name('surtir.editAlm');
Route::post('/surtir/vale/create/{id}', [SurtirController::class, 'storeV'])->name('surtir.storeVale');
Route::get('/vales/surtidos', [SurtirController::class, 'indexSurtido'])->name('surtir.indexSurtido');
Route::get('/surtir/vale/{id}', [SurtirController::class, 'createV'])->name('surtir.createVale');
Route::get('/getFactura', [SurtirController::class, 'getFactura'])->name('surtir.getFactura');


Route::get('getArticulo', [ArticuloController::class, 'getArticulo'])->name('articulo.get');
Route::get('getExistencia', [ArticuloController::class, 'getExistencia'])->name('articulo.existencia');
Route::get('/articulo/pdf', [ArticuloController::class, 'pdf'])->name('articulo.pdf');

Route::put('/vale/submit/{id}', [ValeController::class, 'Vsubmit'])->name('vale.submit');

Route::get('/Reportes/diario', [ReporteController::class, 'diario'])->name('reporte.diario');
Route::any('/reporte/salidas', [ReporteController::class, 'pdf'])->name('reporte.pdf');
Route::any('/reporte/entradas', [ReporteController::class, 'entradas'])->name('reporte.entradas');
Route::get('/reporte/diferencias', [ReporteController::class, 'diferencias'])->name('reporte.diferencias');

Route::resource('/usuario', UsuarioController::class)->middleware('rol:ti,admin,alm');
Route::resource('/up', UpController::class)->middleware('rol:ti,admin,alm');
Route::resource('/area', AreaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/departamento', DepartamentoController::class)->middleware('rol:ti,admin,alm');
Route::resource('/partida', PartidaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/articulo', ArticuloController::class)->middleware('rol:ti,admin,alm');
Route::resource('/proveedor', ProveedorController::class)->middleware('rol:ti,admin,alm');
Route::resource('/recurso', OrigenRecursoController::class)->middleware('rol:ti,admin,alm');
Route::resource('/unidadesmedicion', UnidadMedidaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/vale', ValeController::class)->middleware('rol:user');
Route::resource('/factura', FacturaController::class)->middleware('rol:ti,admin,alm');
Route::resource('/surtir', SurtirController::class)->middleware('rol:ti,admin,alm');






