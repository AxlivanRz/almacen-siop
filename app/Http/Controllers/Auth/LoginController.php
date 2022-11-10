<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        
        $user = User::where('nombre_usuario', $request->nombre_usuario)->first();
        $contraIn = $request->contrasena;
       
        if (empty($user)){
            throw ValidationException::withMessages([
                'nombre_usuario' =>'Estas credenciales no coinciden con nuestros registros',
            ]);  
    
        }else{
            $contraseniaU = $user->contrasena;
            $contraIn = $request->contrasena;
            if(Hash::check($contraIn, $contraseniaU)){
                Auth::login($user);
                $request->session()->regenerate();
                return redirect( route('inicio'));
                }
                throw ValidationException::withMessages([
                    'contrasena' =>'Estas credenciales no coinciden con nuestros registros',
                ]);
        }   
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}