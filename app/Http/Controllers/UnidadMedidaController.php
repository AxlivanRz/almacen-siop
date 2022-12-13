<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnidadMedida;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medidas = UnidadMedida::paginate(15);
        return view ('Medida.index', compact('medidas'));
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
            $create = new UnidadMedida;
            $create->nombre_medida = $request->medida;
            $create->abreviado = $request->abreviado;
            $create->save();
            return redirect('/unidadesmedicion')->with('exito', $create->nombre_medida.' se guardo con éxito');
        } catch (\Throwable $th) {
            return redirect('/unidadesmedicion')->with('no', 'Algo salio mal');
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
            $edit = UnidadMedida::findOrFail($id);
            $edit->nombre_medida = $request->medida;
            $edit->abreviado = $request->abreviado;
            $edit->save();
            return redirect('/unidadesmedicion')->with('exito', $edit->nombre_medida.' se guardo con éxito' );
        } catch (\Throwable $th) {
            return redirect('/unidadesmedicion')->with('no', 'Algo salio mal' );
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
            $delete = UnidadMedida::findOrFail($id);
            $delete->delete();
            return redirect('/unidadesmedicion')->with('exito', $delete->nombre_medida.' se elimino correctamente' );
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/unidadesmedicion')->with('no', 'Algo salio mal');
        }
    }
    public function getMedida(){
        $medidas[] = array();
        $query = UnidadMedida::get();
        return ($query);
    }
}
