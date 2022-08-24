<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isTi')){
            $roles = Rol::get();
        }elseif (Gate::allows('isAdmin')) {
            $roles = DB::table('rols')
            ->where('id_rol', '2')
            ->orWhere(function($query) {
                $query->where('id_rol', '4');
            })
            ->get();
            
        }elseif (Gate::allows('isAlm')) {
            $roles = DB::table('rols')
            ->where('id_rol', '2')
            ->get();
        }
        $user['user'] = User::paginate(15);
        
    
        //return view ('Usuario.index', ['roles' => $roles]); 
        return view('Usuario.index', $user ,  compact(['roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if($request->ajax()){
        //     $roles = Rol::where('id_rol', $request->id_Rol)->first();
        //     $permiso = $roles->permisos; 
        //     return  $permiso;
        //   }
            // $roles = Rol::all(); 
            // return view ('Usuario.create', ['roles' => $roles]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        $create = new User; 
        $create -> nombre = $request->nombre_us;
        $create -> primer_apellido = $request->primer;
        $create -> segundo_apellido = $request->segundo;       
        $create -> nombre_usuario = $request->username;
        $create -> contrasena = Hash::make($request->contrasena);
        $create->save();
        if ($request->rol !=null) {
            $create->roles()->attach($request->rol);
            $create->save();
        }
        return redirect('/usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show( $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit( $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = User::findOrFail($id);
        $edit -> nombre = $request->nombre_us;
        $edit -> primer_apellido = $request->primer;
        $edit -> segundo_apellido = $request->segundo;       
        $edit -> nombre_usuario = $request->username;
        if ($edit->contrasena !=null) {
            $edit->contrasena = Hash::make($request->contrasena);
        }else{
            $edit->contrasena =$request->contra2;
        }
        $edit->roles()->detach();
        if ($request->rol !=null) {
            $edit->roles()->attach($request->rol);
            $edit->save();
        }
        return redirect('/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $user = User::findOrFail($id); 
        $user->roles()->detach();
        $user->delete();
        return redirect('/usuario');
    }
}
