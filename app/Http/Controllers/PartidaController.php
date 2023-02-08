<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Partida;

class PartidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['partidas'] = Partida::paginate(15);
        return view('Partida.index', $datos);
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
        $request->validate([
            'clave' => 'required | unique:App\Models\Partida,descripcion_partida',
        ],
            [
            'clave.unique' => 'La clave de partida ya existe',
        ]);
        try {
            $create = new Partida; 
            $create -> nombre_partida = $request->nombre_partida;
            $create -> descripcion_partida = $request->desc_partida;
            $create -> abreviado = $request->abreviado;
            $create->save();
            return redirect('/partida')->with('exito', $create->nombre_partida.' se guardo con éxito');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/partida')->with('no', 'Algo salio mal');
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
        $edit = Partida::findOrFail($id); 
        $request->validate([
            'descripcion_partida' => Rule::unique('partidas', 'descripcion_partida')->ignore($edit->id_partida),
        ],
            [
            'descripcion_partida.unique' => 'La clave de la partida ya existe',
        ]);
        try {
            $edit -> nombre_partida = $request->nombre_partida;
            $edit -> descripcion_partida = $request->desc_partida;
            $edit -> abreviado = $request->abreviado;
            $edit->save();
            return redirect('/partida')->with('exito', $edit->nombre_partida.' se guardo con éxito');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/partida')->with('no', 'Algo salio mal');
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
            $delete = Partida::findOrFail($id);
            $delete -> delete();
            return redirect('/partida')->with('exito', $edit->nombre_partida.' se elimino correctamente');
        } catch (\Throwable $th) {
            return redirect('/partida')->with('no', 'Algo salio mal');
        }
        
    }
}
