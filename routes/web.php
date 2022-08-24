<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UpController;
use App\Http\Controllers\AreaController;
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

Route::resource('/up', UpController::class)->middleware('auth');
Route::resource('/area', AreaController::class)->middleware('auth');






