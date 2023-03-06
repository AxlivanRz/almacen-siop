<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\EntradaArticulo;
use App\Models\vale_articulo;
use App\Models\ValeSurtido;
use App\Models\Departamento;
use App\Models\Partida;
use App\Models\Factura;
use App\Models\Vale;
use App\Models\User;
use App\Models\Area;
use Carbon\Carbon;
use PDF;

class SurtirController extends Controller
{
    
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
        $partidas = Partida::get();
        $articulos = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->where('entrada_articulos.existencia', '>', 0)
        ->select('entrada_articulos.precio', 'entrada_articulos.factura_id', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id', 'entrada_articulos.caducidad',  'articulos.partida_id')
        ->orderBy('entrada_articulos.caducidad','desc')->get();
        return view('inicio', compact(['vales', 'statusUno', 'statusDos', 'statusTres', 'surtido', 'articulos', 'partidas']));
    }

    public function indexSurtido(Request $request){
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $busqueda = $request->busqueda;
        if ($busqueda == null) {
            $surtidos = ValeSurtido::latest('fecha')->paginate(15);
        }else{
            $surtidos = ValeSurtido::where('id', '=', $busqueda)
            ->paginate(15);
        }
        return view('Surtir.indexSurtidos', compact(['surtidos', 'usuarios', 'areas', 'departamentos', 'busqueda']));
    }

    public function indexAdmin(){
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $vales = DB::table('vales')->orderBy('fecha', 'desc')->paginate(15);
        return view('Surtir.indexAdmin', compact(['vales', 'usuarios', 'areas', 'departamentos']));
    }

    public function index()
    {
        $usuarios = User::get();
        $areas = Area::get();
        $departamentos = Departamento::get();
        $surtidos = ValeSurtido::get();
        $vales = DB::table('vales')->orderBy('fecha', 'desc')->paginate(15);
        return view('Surtir.index', compact(['surtidos', 'usuarios', 'areas', 'departamentos', 'vales']));
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
        // $inv_nombre = "inventario";
        // if ($request->nombre == $inv_nombre) {
        //     $inventario = DB::table('inventario_existencias')
        //     ->where('id', $request->id)
        //     ->get();
        //     return  $inventario;
        // }
        $entrada = DB::table('entrada_articulos')
        ->where('id', $request->id)
        ->get();
        return  $entrada;
    }

    public function storeV(Request $request, $id)
    {
        try {
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
            return redirect ('/inicio')->with('exito', 'Se envío con éxito el vale solicitado N°'.$vale->id);
        } catch (\Throwable $th) {
            return redirect ('/inicio')->with('no', 'Algo salió mal con el vale solicitado N°'.$vale->id);

        }

    }
   
    public function show($id)
    {
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $valeArticulos = $vale->articulos;
        $departamentos = Departamento::get();
        $areas = Area::get();
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $id)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'entrada_articulos.factura_id')
        ->get();
        $facturas = Factura::get();
        return view('Surtir.show', compact(['vale', 'valeArticulos', 'surtido', 'queryEFAs', 'facturas', 'usuarios', 'departamentos', 'areas']));
    }

    public function pdf($id)
    {
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $valeArticulos = $vale->articulos;
        $departamentos = Departamento::get();
        $areas = Area::get();
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $id)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'entrada_articulos.factura_id')
        ->get();
        $facturas = Factura::get();
        $pdf = PDF::loadView('Surtir.valePDF', compact(['vale', 'valeArticulos', 'surtido', 'queryEFAs', 'facturas', 'usuarios', 'departamentos', 'areas']));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream();
    }

    public function submitAlmacen($id)
    {
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($id);
        $vale = Vale::findOrFail($surtido->vale_id);
        $departamentos = Departamento::get();
        $areas = Area::get();
        $valeArticulos = $vale->articulos;
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $id)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'entrada_articulos.factura_id')
        ->get();
        $facturas = Factura::get();
        return view('Surtir.editAdmin', compact(['vale', 'valeArticulos', 'surtido', 'queryEFAs', 'facturas', 'usuarios', 'departamentos', 'areas'])); 
    }

    public function update(Request $request, $id)
    {
        try {
            $surtido = ValeSurtido::findOrFail($id);
            $vale = Vale::findOrFail($surtido->vale_id);
            $date = Carbon::now();
            $vale->status = 4;
            $vale->save();
            $surtido->fecha = $date;
            $surtido->capturista_id = $request->user()->id_usuario;
            $surtido->save();
            return redirect('/surtir')->with('exito', 'Se surtió con éxito el vale solicitado N°'.$vale->id. ', generando un vale surtido con N°'. $id);
        } catch (\Throwable $th) {
            return redirect('/surtir')->with('no', 'Algo salió mal con el vale solicitado N°'.$vale->id);

        }
    }

}
