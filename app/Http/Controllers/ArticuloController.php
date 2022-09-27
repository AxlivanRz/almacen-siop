<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Articulo;


class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidas = Partida::get();
        $articulos = Articulo::paginate(15);
        return view('Articulo.index', compact(['articulos', 'partidas']));
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
        $create = new Articulo;
        $create -> nombre_articulo = $request->nombreAr;
        $create -> unidad_medida = $request->unidad;
        $create -> partida_id = $request->partida;
        $create->save();
        return redirect('/articulo');
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
        $edit = Articulo::findOrFail($id);
        $edit -> nombre_articulo = $request->nombreAr;
        $edit -> unidad_medida = $request->unidad;
        if ($request->partida !=null) {
            $edit -> partida_id = $request->partida;
        }
        $edit->save();
        return redirect('/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Articulo::findOrFail($id); 
        $delete->delete();
        return redirect('/articulo');
    }
}
