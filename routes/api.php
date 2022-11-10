<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

Route::middleware('auth:web')->get('/usuario', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=> ['web']], function(){
   
});

