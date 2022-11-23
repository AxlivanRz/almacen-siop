<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vale;
use App\Models\vale_articulo;
use App\Models\Factura;
use App\Models\EntradaArticulo;
use App\Models\ValeSurtido;
use App\Models\User;
use App\Models\Area;
use App\Models\Departamento;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
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
        $statusUno = DB::table('vales')
        ->where('status', 1)->get();
        $statusDos = DB::table('vales')
        ->where('status', 2)->get();
        $statusTres = DB::table('vales')
        ->where('status', 3)->get();
        return view('inicio', compact(['vales', 'statusUno', 'statusDos', 'statusTres']));
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
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $vales = Vale::get();
        return view('Surtir.index', compact(['vales', 'usuarios', 'areas', 'departamentos']));
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
    public function createV($id)
    {
        $facturas = Factura::get();
        $vale = Vale::findOrFail($id);
        $valeArticulos = $vale->articulos;
        $entradas = EntradaArticulo::get();
        $articulos = DB::table('articulos')
        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        ->get();
        return view('Surtir.create', compact(['vale', 'valeArticulos', 'articulos', 'entradas', 'facturas'])); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeV(Request $request)
    {
        //
    }
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
        $articulos = DB::table('articulos')
        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        ->get();
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
        
            $editVale = Vale::findOrFail($id);
            $editVale->status = 2;
            $date = Carbon::now()->isoFormat('YYYY/MM/DD, kk:mm:ss');
            $editVale->fecha_aprovado = $date;
            $editVale->administrador_id = $request->user()->id_usuario;
            $editVale->save();
            $editVale->articulos()->detach();
            if ($request->articulokey !=null) { 
                foreach($request->get('articulokey') as $key => $value){
                    $cantidad = $request->get('cantidadkey')[$key];
                    $editVale->articulos()->attach($value, ['cantidad' => $cantidad]);
                    $editVale->save();
                }
            }
            return redirect('/vale/confirmacion');
        
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
