<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ups;
use App\Models\Area;
use Illuminate\Support\Facades\DB;
class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::get();
        $ups = Ups::get();
        $datos['areas'] = Area::paginate(15);
        return view('Area.index', $datos, compact(['ups', 'usuarios']));
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
        $create = new Area; 
        $create -> nombre_area = $request->nombre_ar;
        $create -> descripcion_area = $request->desc_ar;
        $create -> up_id = $request->up;   
        $create -> usuario_id = $request->us;    
        $create->save();
        return redirect('/area');
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
        $edit = Area::findOrFail($id); 
        $edit -> nombre_area = $request->nombre_ar;
        $edit -> descripcion_area = $request->desc_ar;
        if ($request->up !=null) {
            $edit -> up_id = $request->up;   
        }
        if ($request->us !=null) {
            $edit -> usuario_id = $request->us;  
        }    
        $edit->save();
        return redirect('/area');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
