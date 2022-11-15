<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vale;
use App\Models\vale_articulo;
use App\Models\Factura;
use App\Models\EntradaArticulo;
use App\Models\ValeSurtido;
use Illuminate\Support\Facades\DB;

class SurtirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexS(){
        $vales = Vale::get();
        $surtidos = ValeSurtido::get();
        return view('inicio', compact('vales'));
    }
    public function indexAdmin(){
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $vales = Vale::get();
        return view('Surtir.indexAdmin', compact(['vales', 'usuarios', 'areas', 'departamentos']));
    }
    public function index()
    {
       
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
        //
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
    public function editAdmin($id)
    {
        $vale = Vale::findOrFail($id);
        $valeArticulos = $vale->articulos;
        $articulos = '';
        foreach ($entradas as $entrada) {
            $articulos = DB::table('articulos')
            ->where('id', $entrada->id)->get();
        }
        return view('Surtir.editAdmin', compact(['vale', 'valeArticulos', 'articulos'])); 
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
        if (Gate::allows('isAdmin')) {
            $editVale = Vale::findOrFail($id);
            $editVale->status = 2;
            $date = Carbon::now()->isoFormat('YYYY/MM/DD, kk:mm:ss');
            $editVale->fecha_aprovado = $date;
            $createVale->administrador_id = $request->user()->id_usuario;
            $editVale->save();
            $editVale->articulos()->detach();
            if ($request->articulokey !=null) { 
                foreach($request->get('articulokey') as $key => $value){
                    $cantidad = $request->get('cantidadkey')[$key];
                    $editVale->articulos()->attach($value, ['cantidad' => $cantidad]);
                    $editVale->save();
                }
            }
            return redirect('/vale');
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
        //
    }
}
