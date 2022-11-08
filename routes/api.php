<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ValeController;
use App\Http\Controllers\LoginController;

Route::middleware('auth:sanctum')->get('/usuario', function (Request $request) {
    return $request->user();
});
Route::get('vale', [ValeController::class, 'index'])->name('vale.index');
Route::group(['middleware'=> ['auth:sanctum']], function(){
    Route::get('vale/create', [ValeController::class, 'create'])->name('vale.create');
    Route::get('vale/{id}', [ValeController::class, 'show'])->name('vale.show');
    Route::post('vale/store', [ValeController::class, 'store'])->name('vale.store');
    Route::put('vale/edit/{id}',[ValeController::class, 'update'])->name('vale.update');
});

