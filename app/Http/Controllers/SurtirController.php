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
        $surtido = DB::table('vales')
        ->where('status', 4)->get();
        return view('inicio', compact(['vales', 'statusUno', 'statusDos', 'statusTres', 'surtido']));
    }
    public function indexSurtido(){
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $surtidos = ValeSurtido::get();
        return view('Surtir.indexSurtidos', compact(['surtidos', 'usuarios', 'areas', 'departamentos']));
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
    public function getFactura(Request $request){
        $entrada = DB::table('entrada_articulos')
        ->where('id', $request->id)
        ->get();
        return  $entrada;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeV(Request $request, $id)
    {
        $createSurtido = new ValeSurtido;
        $date = Carbon::now();
        $vale = Vale::findOrFail($id);
        $vale->status = 4;
        $vale->save();
        $createSurtido->fecha = $date;
        $createSurtido->total = $request->total;
        $createSurtido->vale_id = $id;
        if (Gate::allows('isAlm')) {
        $createSurtido->capturista_id = $request->user()->id_usuario;
        }
        $createSurtido->save();
        if ($request->get('entrada') !=null) { 
            foreach($request->get('entrada') as $key => $value){
                $entrada = EntradaArticulo::findOrFail($value);
                $existencia = $entrada->existencia;
                $cantidad = $request->get('cantidad')[$key];
                $entrada->existencia = $existencia - $cantidad;
                $entrada->save();
                $createSurtido->entradas()->attach( $value, ['cantidad' => $cantidad]);
                $createSurtido->save();
            }
        }
        return redirect ('/inicio'); 
    }
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $surtido = ValeSurtido::findOrFail($id);
        // $vale = Vale::findOrFail($surtido->vale_id);
        // $diferentes = DB::table('vale_articulos')
        // ->where('vale_id', '=', $id)
        // ->join('articulos', 'vale_articulos.articulo_id', '!=', 'articulos.id')
        // ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        // ->where('entrada_articulos.existencia', '>',  0)
        // ->select('articulos.id','articulos.nombre_articulo', 'articulos.nombre_med')
        // ->get();
        // $articulos = $diferentes->unique('nombre_articulo');
        // return view('Surtir.editAdmin', compact(['vale', 'valeArticulos', 'surtido']));
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
        $diferentes = DB::table('vale_articulos')
        ->where('vale_id', '=', $id)
        ->join('articulos', 'vale_articulos.articulo_id', '!=', 'articulos.id')
        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        ->where('entrada_articulos.existencia', '>',  0)
        ->select('articulos.id','articulos.nombre_articulo', 'articulos.nombre_med')
        ->get();
        $articulos = $diferentes->unique('nombre_articulo');
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
        $date = Carbon::now();
        $editVale->status = 2;
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
