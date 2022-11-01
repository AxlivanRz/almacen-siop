<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Articulo;
use App\Models\UnidadMedida;
use PDF;

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
        $medidas = UnidadMedida::get();
        $articulos = Articulo::paginate(15);
        return view('Articulo.index', compact(['articulos', 'partidas', 'medidas']));
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
        $create -> clave_articulo = $request->clave;
        $create -> ubicacion = $request->ubicacion;
        $create -> observaciones = $request->observaciones;
        $create -> medida_id = $request->medida;
        $idmed = $request->medida;
        $nombremed = UnidadMedida::findOrFail($idmed);
        $create -> nombre_med = $nombremed->nombre_medida;
        $create -> partida_id = $request->partida;
        if ($request->hasFile('foto_articulo')) {
            $create['foto_articulo']=$request->file('foto_articulo')->store('uploads', 'public');
        }
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
        $edit -> clave_articulo = $request->clave;
        $edit -> ubicacion = $request->ubicacion;
        $edit -> observaciones = $request->observaciones;
        $edit -> medida_id = $request->medida;
        $idmed = $request->medida;
        $nombremed = UnidadMedida::findOrFail($idmed);
        $edit -> nombre_med = $nombremed->nombre_medida;
        if ($request->partida !=null) {
            $edit -> partida_id = $request->partida;
        }
        if ($request->hasFile('foto')) {
            $edit['foto_articulo']=$request->file('foto')->store('uploads', 'public');
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
    public function getArticulo(){
        $articulos[] = array();
        $query = Articulo::get();
        return ($query);
    }
    public function pdf(){
        $articulos = Articulo::paginate();
        $pdf = PDF::loadView('Articulo.pdfV', ['articulos'=>$articulos]);
        //$pdf->set_paper ('a4','landscape');
        return $pdf->stream();
        //return view ('Articulo.pdf', compact('articulos'));
    }
}
