<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Area;
use App\Models\Departamento;
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
        $areas = Area::get();
        $departamentos = Departamento::get();
    
        //return view ('Usuario.index', ['roles' => $roles]); 
        return view('Usuario.index', $user ,  compact(['roles', 'areas', 'departamentos']));
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
        $request->validate([
            'nombre_us' => 'required',
            'primer' => 'required',
            'username' => 'required | unique:App\Models\User,nombre_usuario| min:6',
            'areaus' => 'required_unless:departamento,null',
            'departamento' => 'required_unless:areaus,null',
            'rol' => 'required',
            'contrasena' => 'required | min:6',
        ],
            [
            'nombre_us.required' => 'Este campo NO puede estar vacío',
            'primer.required' => 'Este campo NO puede estar vacío',
            'contrasena.required' => 'Este campo NO puede estar vacío',
            'username.required' => 'Este campo NO puede estar vacío',
            'areaus.required_unless' => 'Este campo NO puede estar vacío',
            'departamento.required_unless' => 'Este campo NO puede estar vacío',
            'rol.required' => 'Este campo NO puede estar vacío',
            'username.unique' => 'El nombre de usuario ya existe',
            'username.min' => 'El nombre de usuario debe tener minímo 6 caracteres'
        ]);
        $create = new User; 
        $create -> name = $request->nombre_us;
        $create -> primer_apellido = $request->primer;
        $create -> segundo_apellido = $request->segundo;       
        $create -> nombre_usuario = $request->username;
        $create -> contrasena = Hash::make($request->contrasena);
        $create->save(); 
        if ($request->areaus!=null && $request->areaus != 0) {
            $create -> area_id = $request->areaus; 
            $create->save(); 
        }
        if ($request->departamento !=null && $request->departamento != 0) {
            $create -> departamento_id = $request->departamento;
            $create->save(); 
        }
        if ($request->rol !=null) { 
            $create->roles()->attach($request->rol);
            $create->save();
        }
        return redirect('/usuario')->with('post',  $create->name.' se agrego con éxito');
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
        $edit -> name = $request->nombre_us;
        $edit -> primer_apellido = $request->primer;
        $edit -> segundo_apellido = $request->segundo;       
        $edit -> nombre_usuario = $request->username;
        $contrasena1 = $edit->contrasena;
        if ($request->contrasena !=null) {
            $edit->contrasena = Hash::make($request->contrasena);
        }else{
            $edit->contrasena =$contrasena1;
        }
        if ($request->areaus != 0 && $edit->departamento_id != null || $edit->area_id != $request->areaus && $request->areaus != 0) {
            $edit -> departamento_id = null;
            $edit -> area_id = $request->areaus; 
            $edit->save(); 
        }else{
            if ($request->departamento != 0 && $edit->area_id != null || $edit->departamento_id != $request->departamento && $request->departamento != 0) {
                $edit -> area_id = null;
                $edit -> departamento_id = $request->departamento;
                $edit->save(); 
            }
        }
        $edit->roles()->detach();
        if ($request->rol !=null) {
            $edit->roles()->attach($request->rol);
            $edit->save();
        }
        return redirect('/usuario')->with('put', 'Se actualizo el registro de '.$edit->name.' con éxito');
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
        return redirect('/usuario')->with('delete', $user->name.' se elimino con exito');
    }
}
