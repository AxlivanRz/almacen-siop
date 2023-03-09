<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Models\InventarioExistencia;
use App\Models\InventarioInicial;
use App\Exports\ExistenciaExport;
use App\Exports\ComparativoExport;
use App\Models\EntradaArticulo;
use App\Models\InventarioFinal;
use App\Exports\EntradaExport;
use App\Exports\SalidaExport;
use App\Models\OrigenRecurso;
use App\Models\Departamento;
use App\Models\ValeSurtido;
use App\Models\Factura;
use App\Models\Partida;
use App\Models\Area;
use App\Models\User;
use Carbon\Carbon;
use PDF;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function diario()
    {
        $recursos = OrigenRecurso::get();
        $partidas = Partida::get();
        return view('Reporte.indexDiario', compact('recursos', 'partidas'));
    }
  
    public function cierre(Request $request){
        //try {
            $iniI = Carbon::parse($request->mesCierre)->startOfMonth()->toDateString();
            $finF = Carbon::parse($request->mesCierre)->endOfMonth()->toDateString();
            $tomorrow = Carbon::parse($request->mesCierre)->endOfMonth()->addDay()->toDateString();
            $nombre = Carbon::parse($request->mesCierre)->isoFormat('MMMM');
            $ano = Carbon::parse($request->mesCierre)->endOfMonth()->addDay()->isoFormat('MM/YY');
            $ano01 = Carbon::parse($request->mesCierre)->endOfMonth()->addDay()->isoFormat('YYYY');
            $inicio = $ano01."-01-01";
            $recursos = DB::table('origen_recursos')->orderBy('id_origen', 'asc')->get();
            // 1. Sumatoria total para Inventarios inicial y final
            $total_existencias = DB::table('articulos')
            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
            ->where('entrada_articulos.existencia', '>',  0)
            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
            ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as suma')
            ->get();
            // 1. Cierre

            // 2. Sumatoria por recurso        
            foreach ($recursos as $recurso) {
                $total_existencia_recurso[$recurso->id_origen] = DB::table('articulos')
                ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                ->where('entrada_articulos.existencia', '>',  0)
                ->where('facturas.recurso_id', '=', $recurso->id_origen)
                ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
                ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as suma_recurso')
                ->get();
            }
            // 2. Cierre
            $value_total = $total_existencias[0]->suma;
            $inventario_final = new InventarioFinal;
            $inventario_final->fecha = $finF;
            $inventario_final->total = $value_total;
            $inventario_final->save();
            $inventario_inicial = new InventarioInicial;
            $inventario_inicial->fecha = $tomorrow;
            $inventario_inicial->total = $value_total;
            $inventario_inicial->save();
            
            $existencias = DB::table('articulos')
            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
            ->where('entrada_articulos.existencia', '>',  0)
            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
            ->select('entrada_articulos.articulo_id', 'entrada_articulos.iva', 'entrada_articulos.caducidad', 'entrada_articulos.existencia', 'entrada_articulos.cantidad', 'entrada_articulos.precio',  'entrada_articulos.id', 'facturas.recurso_id', 'facturas.proveedor_id')
            ->get();
            foreach ($recursos as $recurso) {
                if (isset($total_existencia_recurso[$recurso->id_origen][0])) {
                    $numerof = "inv/".$ano."/".$recurso->nombre_recurso;
                    $new_factura = new Factura();
                    $new_factura->fecha = $tomorrow;
                    $new_factura->numero_factura = $numerof;
                    $new_factura->proveedor_id = 1;
                    $new_factura->respaldo_factura = null;
                    $new_factura->imp_iva = 0;
                    $new_factura->imp_total =  $total_existencia_recurso[$recurso->id_origen][0]->suma_recurso;
                    $new_factura->subtotal = 0;
                    $new_factura->confirmed = 1;
                    $new_factura->recurso_id = $recurso->id_origen;
                    $new_factura->created_at = $tomorrow;
                    $new_factura->updated_at = $tomorrow;
                    $new_factura->save();
                    $numerofa = null;
                }
            }
            foreach ($existencias as $value) {
                foreach ($recursos as $recurso) {
                    if ($value->recurso_id == $recurso->id_origen) {
                        $numerofa = "inv/".$ano."/".$recurso->nombre_recurso;
                        $totalNew =($value->existencia) * ($value->precio);
                        $entrada = EntradaArticulo::findOrFail($value->id);
                        $iva_new= ($entrada->imp_unitario / $entrada->cantidad) * $value->existencia;
                        $base_new=  $totalNew - $iva_new;
                        $entrada->existencia = 0;
                        $entrada->save();
                        $new_entrada = new EntradaArticulo();
                        $new_entrada->cantidad = $value->existencia;
                        $new_entrada->existencia = $value->existencia;
                        $new_entrada->precio = $value->precio;
                        $new_entrada->iva = $value->iva;
                        $new_entrada->factura_id = $numerofa;
                        $new_entrada->descuento = 0;
                        $new_entrada->base = $base_new;
                        $new_entrada->imp_unitario = $iva_new;
                        $new_entrada->preciofinal = $totalNew;
                        $new_entrada->articulo_id = $value->articulo_id;
                        $new_entrada->created_at = $tomorrow;
                        $new_entrada->updated_at = $tomorrow;
                        if( $value->caducidad != null){
                            $new_entrada->caducidad = $value->caducidad;
                        }
                        $new_entrada->save();
                    }
                    $numerofa = null;
                }              
            }
            return redirect ('/cierre/mensual')->with('exito', 'Se cerro el mes de '.$nombre.' con éxito');
        // } catch (\Throwable $th) {
        //  return redirect ('/cierre/mensual')->with('no', 'Algo salío mal');
        // }
    }

    public function index()
    {
        return view('Excel.index');
    }
    public function entrada(Request $request)
    {
        $fI = $request->inicio;
        $fF = $request->final;
        $entradas = DB::table('entrada_articulos')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('facturas.fecha', [$fI, $fF])
        ->get();
        $fecha = Carbon::parse($fF)->isoFormat('MM-YY');
        return (new EntradaExport($entradas))->download($fecha.'-entradas.xlsx', Excel::XLSX);
    }
    public function salida(Request $request)
    {
        $fI = $request->inicio1;
        $fF = $request->final1;
        $salidas = DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
        ->get();
        $fecha = Carbon::parse($fF)->isoFormat('MM-YY');
        return (new SalidaExport($salidas))->download($fecha.'-salidas.xlsx', Excel::XLSX);
    }
    public function existencia()
    {
        $entradas = DB::table('entrada_articulos')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->where('entrada_articulos.existencia','>', 0 )
        ->get();
        $fecha = Carbon::now()->isoFormat('MM-YY');
        return (new ExistenciaExport($entradas))->download($fecha.'-existencias.xlsx', Excel::XLSX);
    }
    public function comparativoES(Request $request){
        $fI = $request->fecha_inicio2;
        $fF = $request->fecha_final2;
        $ano01 = Carbon::parse($request->inicio2)->isoFormat('YYYY');
        $inicio = Carbon::parse($ano01."-01-01")->isoFormat('YYYY-MM-DD');
        $salidas_0 = DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->where('entrada_articulos.existencia', '=', 0)
        ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
        ->select('entrada_articulos.*', 'facturas.*');
        $entradas = DB::table('entrada_articulos')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->where('entrada_articulos.existencia', '>', 0)
        ->whereBetween('facturas.fecha', [$inicio, $fF])
        ->union($salidas_0)
        ->get();
        foreach ($entradas as $entrada) {
            $salidas[$entrada->id] = DB::table('surtido_entradas')
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->where('surtido_entradas.entrada_articulo_id', '=', $entrada->id)
            ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
            ->select('surtido_entradas.entrada_articulo_id')
            ->selectRaw('SUM(surtido_entradas.cantidad) as suma')
            ->get();
        }
        $fecha = Carbon::parse($fF)->isoFormat('MM-YY');
        return (new ComparativoExport($entradas, $salidas))->download($fecha.'-comparativo.xlsx', Excel::XLSX);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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