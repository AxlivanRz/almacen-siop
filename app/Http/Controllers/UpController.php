<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ups;
use Illuminate\Support\Facades\DB;
class UpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['ups'] = Ups::paginate(15);
        return view('Up.index', $datos);

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
        try {
            $create = new Ups; 
            $create -> nombre_ups = $request->nombre_up;
            $create -> descripcion_ups = $request->desc_up;
            $create -> iniciales = $request->iniciales;       
            $create->save();
            return redirect('/up')->with('exito',  $create->nombre_ups.' se guardo con éxito');
        } catch (\Throwable $th) {
            return redirect('/up')->with('no',  'Algo salío mal con tu registro');
        }
       
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
        try {
            $edit = Ups::findOrFail($id);
            $edit -> nombre_ups = $request->nombre_up;
            $edit -> descripcion_ups = $request->desc_up;
            $edit -> iniciales = $request->iniciales;       
            $edit->save();
            return redirect('/up')->with('exito', 'El registro de '.$edit->nombre_ups.' se actualizo con éxito');
        } catch (\Throwable $th) {
            return redirect('/up')->with('no', 'Algo salío mal con tu registro');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = Ups::findOrFail($id);
            $delete->delete();
            return redirect('/up')->with('exito', 'El registro de '.$delete->nombre_ups.' se elimino correctamente');
        } catch (\Throwable $th) {
            return redirect('/up')->with('no', 'Algo salío mal con tu registro');
        }
       
    }
}
