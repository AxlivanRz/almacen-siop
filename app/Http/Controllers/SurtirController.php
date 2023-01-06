<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\EntradaArticulo;
use App\Models\vale_articulo;
use App\Models\ValeSurtido;
use App\Models\Departamento;
use App\Models\Factura;
use App\Models\Vale;
use App\Models\User;
use App\Models\Area;
use Carbon\Carbon;

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
        $surtidos = ValeSurtido::get();
        $vales = Vale::get();
        return view('Surtir.index', compact(['surtidos', 'usuarios', 'areas', 'departamentos', 'vales']));
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
        $date = Carbon::now();
        $createSurtido = new ValeSurtido;
        $createSurtido->total = $request->total;
        $createSurtido->vale_id = $id;
        $createSurtido->save();
        $vale = Vale::findOrFail($id);
        $vale->fecha_aprovado = $date;
        $vale->administrador_id = $request->user()->id_usuario;
        $vale->status = 2;
        $vale->save();
        if ($request->get('entrada') !=null) { 
            foreach($request->get('entrada') as $key => $value){
                $entrada = EntradaArticulo::findOrFail($value);
                $existencia = $entrada->existencia;
                $cantidad = $request->get('cantidad')[$key];
                $total_art = $request->get('total_art')[$key];
                $entrada->existencia = $existencia - $cantidad;
                $entrada->save();
                $createSurtido->entradas()->attach( $value, ['cantidad' => $cantidad, 'total_articulo' => $total_art]);
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
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $valeArticulos = $vale->articulos;
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $id)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'entrada_articulos.factura_id')
        ->get();
        $facturas = Factura::get();
        return view('Surtir.show', compact(['vale', 'valeArticulos', 'surtido', 'queryEFAs', 'facturas', 'usuarios']));
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
    public function submitAlmacen($id)
    {
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $valeArticulos = $vale->articulos;
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $id)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'entrada_articulos.factura_id')
        ->get();
        $facturas = Factura::get();
        return view('Surtir.editAdmin', compact(['vale', 'valeArticulos', 'surtido', 'queryEFAs', 'facturas', 'usuarios'])); 
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
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $date = Carbon::now();
        $vale->status = 4;
        $vale->save();
        $surtido->fecha = $date;
        $surtido->capturista_id = $request->user()->id_usuario;
        $surtido->save();
        return redirect('/surtir');
        
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
