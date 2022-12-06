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
        $request->validate([
            'nombre_usuario' => 'required',
            'contrasena' => 'required | min:6'
        ],
        [
            'nombre_usuario.required' => 'Este campo NO puede estar vacío',
            'contrasena.required' => 'Este campo NO puede estar vacío',
            'contrasena.min' => 'La contraseña NO coincide con nuestros registros'
        ]
        );
        if (empty($user)){
            throw ValidationException::withMessages([
                'nombre_usuario' =>'El nombre de usuario NO coincide con nuestros registros',
            ]);  
        }else{
            $contraseniaU = $user->contrasena;
            $contraIn = $request->contrasena;
            if(Hash::check($contraIn, $contraseniaU)){
                Auth::login($user);
                $request->session()->regenerate();
                return redirect( route('inicio'))->with('inicio', 'Inicio Sesión con éxito');
            }
            throw ValidationException::withMessages([
                'contrasena' => 'La contraseña NO coincide con nuestros registros',
            ]);
        } 
        
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('fin', 'Hasta luego');
    }
}