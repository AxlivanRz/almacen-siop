<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Area;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::paginate(15);
        return view('Departamento.index', compact(['departamentos', 'areas', 'usuarios']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $create = new Departamento; 
        $create -> nombre_departamento = $request->nombre_dep;
        $create -> descripcion_departamento = $request->desc_dep;
        $create -> area_id = $request->area;   
        $create -> usuario_id = $request->us;    
        $create->save();
        return redirect('/departamento');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = Departamento::findOrFail($id); 
        $edit -> nombre_departamento = $request->nombre_dep;
        $edit -> descripcion_departamento = $request->desc_dep;
        if ($request->area !=null) {
            $edit -> area_id = $request->area;   
        }
        if ($request->us !=null) {
            $edit -> usuario_id = $request->us;  
        }    
        $edit->save();
        return redirect('/departamento');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Departamento::findOrFail($id);
        $delete->delete();
        return redirect('/departamento');
    }
}
