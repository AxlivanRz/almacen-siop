<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrigenRecurso;
use Illuminate\Support\Facades\DB;
class OrigenRecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['recursos'] = OrigenRecurso::paginate(10);
        return view ('Recurso.index', $datos);
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
        $create = new OrigenRecurso; 
        $create -> nombre_recurso = $request->nombre_recurso;
        $create->save();
        return redirect('/recurso');
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
        $edit = OrigenRecurso::findOrFail($id);
        $edit -> nombre_recurso = $request->nombre_recurso;
        $edit->save();
        return redirect('/recurso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = OrigenRecurso::findOrFail($id);
        $delete->delete();
        return redirect('/recurso');
    }
}
