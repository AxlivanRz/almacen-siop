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
    public function pdf(Request $request){
        $fI = $request->inicio;
        $fF = $request->final;
        $fechaIni1= Carbon::parse($request->inicio)->isoFormat('LL');
        $fechaFin1= Carbon::parse($request->final)->isoFormat('LL');
        $partidas = DB::table('partidas')->orderBy('id_partida', 'asc')->get();
        $areas = DB::table('areas')->orderBy('id_area', 'asc')->get();
        if ($request->recurso == 0) {
            foreach ($partidas as $partida) {
                $gastosPartida[$partida->id_partida]= DB::table('surtido_entradas')
                ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                ->where('articulos.partida_id', '=', $partida->id_partida)
                ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
                ->select('surtido_entradas.total_articulo')
                ->sum('total_articulo');
            }
            foreach ($areas as $area) {
                $gastosArea[$area->id_area]= DB::table('surtido_entradas')
                ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                ->join('vales', 'vale_surtidos.vale_id', '=', 'vales.id')
                ->join('areas', 'vales.area_id', '=', 'areas.id_area')
                ->where('areas.id_area', '=', $area->id_area)
                ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
                ->select('surtido_entradas.total_articulo')
                ->sum('total_articulo');
            }
            $gastoFinal= DB::table('surtido_entradas')
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->whereBetween('vale_surtidos.created_at', [$fI, $fF])->select('surtido_entradas.total_articulo')
            ->sum('total_articulo');
            foreach ($areas as $area) {
                foreach ($partidas as $partida) {
                    $gastosV2 = "Select SUM(total_articulo) as suma, AR.nombre_area, P.id_partida,  P.nombre_partida from surtido_entradas as SE
                    inner join vale_surtidos as VS on SE.vale_surtido_id = VS.id
                    inner join vales as V on VS.vale_id = V.id
                    inner join entrada_articulos as EA on SE.entrada_articulo_id = EA.id
                    inner join articulos as A on EA.articulo_id = A.id
                    inner join areas as AR on V.area_id = AR.id_area
                    inner join partidas as P on A.partida_id = P.id_partida
                    where A.partida_id = ".$partida->id_partida." && V.area_id = ".$area->id_area." && VS.created_at between cast('".$fI."' as date) and cast('".$fF."' as date);";
                    $gastos [$area->id_area][$partida->id_partida]= DB::select($gastosV2);
                }
            }
            $pdf = PDF::loadView('Reporte.diario',  compact(['partidas', 'areas', 'gastos', 'gastosPartida', 'gastosArea', 'gastoFinal', 'fechaIni1', 'fechaFin1']));
            $pdf->set_paper ('a4','landscape');
            return $pdf->stream();
        }
        //CON ORIGEN DEL RECURSO
        //CON ORIGEN DEL RECURSO
        $idOR = $request->recurso;
        foreach ($partidas as $partida) {
            $gastosPartida[$partida->id_partida]= DB::table('surtido_entradas')//OR
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->where('facturas.recurso_id', '=', $idOR)
            ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
            ->select( 'surtido_entradas.total_articulo')
            ->sum('total_articulo');//OR
        }
        foreach ($areas as $area) {
            $gastosArea[$area->id_area]= DB::table('surtido_entradas')//OR
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
            ->join('vales', 'vale_surtidos.vale_id', '=', 'vales.id')
            ->join('areas', 'vales.area_id', '=', 'areas.id_area')
            ->where('areas.id_area', '=', $area->id_area)
            ->where('facturas.recurso_id', '=', $idOR)
            ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
            ->select('surtido_entradas.total_articulo')
            ->sum('total_articulo');//OR
        }
        $gastoFinal= DB::table('surtido_entradas')//OR
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->where('facturas.recurso_id', '=', $idOR)
        ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
        ->select('surtido_entradas.total_articulo')
        ->sum('total_articulo');//OR
        foreach ($areas as $area) {//OR
            foreach ($partidas as $partida) {
                $gastosV2 = "Select SUM(total_articulo) as suma, AR.nombre_area, P.id_partida,  P.nombre_partida from surtido_entradas as SE
                inner join vale_surtidos as VS on SE.vale_surtido_id = VS.id
                inner join vales as V on VS.vale_id = V.id
                inner join entrada_articulos as EA on SE.entrada_articulo_id = EA.id
                inner join facturas as FA on EA.factura_id = FA.numero_factura
                inner join articulos as A on EA.articulo_id = A.id
                inner join areas as AR on V.area_id = AR.id_area
                inner join partidas as P on A.partida_id = P.id_partida
                where A.partida_id = ".$partida->id_partida." && V.area_id = ".$area->id_area."
                && FA.recurso_id = ".$idOR." && VS.created_at between cast('".$fI."' as date) and cast('".$fF."' as date);";
                $gastos [$area->id_area][$partida->id_partida]= DB::select($gastosV2);
            }
        }//OR
        $pdf = PDF::loadView('Reporte.diario',  compact(['partidas', 'areas', 'gastos', 'gastosPartida', 'gastosArea', 'gastoFinal', 'fechaIni1', 'fechaFin1']));
        $pdf->set_paper('a4','landscape');
        return $pdf->stream();
    }

    public function entradas(Request $request)
    {
        $fI = $request->inicio2;
        $fF = $request->final2;
        $fechaIni1= Carbon::parse($request->inicio2)->isoFormat('LL');
        $fechaFin1= Carbon::parse($request->final2)->isoFormat('LL');
        $partidas = DB::table('partidas')->orderBy('id_partida', 'asc')->get();
        $anterior_fF = Carbon::parse($request->inicio2)->addDay(-1)->endOfMonth()->toDateString();
        $ano = Carbon::parse($request->inicio2)->endOfMonth()->addDay()->isoFormat('YYYY');
        $inicio = $ano."-01-01";
        if ($request->recurso2 == 0) {
            foreach ($partidas as $partida) {
                $gastosPartida[$partida->id_partida]= DB::table('facturas')
                ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
                ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                ->where('articulos.partida_id', '=', $partida->id_partida)
                ->whereBetween('facturas.created_at', [$fI, $fF])
                ->select('entrada_articulos.preciofinal')
                ->sum('preciofinal');
                // $gastosPartida1[$partida->id_partida]= DB::table('facturas')
                // ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
                // ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                // ->where('articulos.partida_id', '=', $partida->id_partida)
                // ->whereBetween('facturas.created_at', [$inicio, $anterior_fF])
                // ->where('entrada_articulos.existencia', '>', 0)
                // ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as gasto_partida')
                // ->get();
                // $gastosPartida[$partida->id_partida] = $gastosPartida0[$partida->id_partida] + $gastosPartida1[$partida->id_partida][0]->gasto_partida;
            }
            $gastoFinal= DB::table('facturas')
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->whereBetween('facturas.created_at', [$fI, $fF])
            ->select('entrada_articulos.preciofinal')->sum('preciofinal');
            // $gastoFinal1= DB::table('facturas')
            // ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            // ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            // ->where('entrada_articulos.existencia', '>', 0)
            // ->whereBetween('facturas.created_at', [$inicio, $anterior_fF])
            // ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as gasto_final')
            // ->get();
            // $gastoFinal =  $gastoFinal1[0]->gasto_final + $gastoFinal0;
            $pdf = PDF::loadView('Reporte.entradas',  compact(['partidas', 'gastosPartida', 'gastoFinal', 'fechaIni1', 'fechaFin1']));
            $pdf->setPaper('A4','portrait');
            return $pdf->stream();
        }
        //CON ORIGEN DEL RECURSO
        //CON ORIGEN DEL RECURSO
        $idOR = $request->recurso2;
        foreach ($partidas as $partida) {
            $gastosPartida0[$partida->id_partida]= DB::table('facturas')//OR
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('facturas.recurso_id', '=', $idOR)
            ->whereBetween('facturas.created_at', [$fI, $fF])
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->select('entrada_articulos.preciofinal')
            ->sum('preciofinal');
            $gastosPartida1[$partida->id_partida]= DB::table('facturas')
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('facturas.recurso_id', '=', $idOR)
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->whereBetween('facturas.created_at', [$inicio, $anterior_fF])
            ->where('entrada_articulos.existencia', '>', 0)
            ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as gasto_partida')
            ->get();
            $gastosPartida[$partida->id_partida] = $gastosPartida0[$partida->id_partida] + $gastosPartida1[$partida->id_partida][0]->gasto_partida;
        }
        $gastoFinal0= DB::table('facturas')//OR
        ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->where('facturas.recurso_id', '=', $idOR)
        ->whereBetween('facturas.created_at', [$fI, $fF])
        ->select('entrada_articulos.preciofinal')->sum('preciofinal');//OR
        $gastoFinal1= DB::table('facturas')
        ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->where('entrada_articulos.existencia', '>', 0)
        ->where('facturas.recurso_id', '=', $idOR)
        ->whereBetween('facturas.created_at', [$inicio, $anterior_fF])
        ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as gasto_final')
        ->get();
        $gastoFinal =  $gastoFinal1[0]->gasto_final + $gastoFinal0;
        $pdf = PDF::loadView('Reporte.entradas',  compact(['partidas', 'gastosPartida', 'gastoFinal', 'fechaIni1', 'fechaFin1']));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream();
    }
    public function diferencias(Request $request){
        $fI = $request->inicio3;
        $fF = $request->final3;
        $fechaIni1= Carbon::parse($request->inicio3)->isoFormat('LL');
        $fechaFin1= Carbon::parse($request->final3)->isoFormat('LL');
        $partidas = DB::table('partidas')->orderBy('id_partida', 'asc')->get();
        $anterior_fF = Carbon::parse($request->inicio2)->addDay(-1)->endOfMonth()->toDateString();
        $ano = Carbon::parse($request->inicio2)->endOfMonth()->addDay()->isoFormat('YYYY');
        $inicio = $ano."-01-01";
        $gastoFinalVal= DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
        ->select('surtido_entradas.total_articulo')
        ->sum('total_articulo');
        foreach ($partidas as $partida) {
            $gastosVales[$partida->id_partida]= DB::table('surtido_entradas')
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
            ->select('surtido_entradas.total_articulo')
            ->sum('total_articulo');
        }
        //Facturas
        foreach ($partidas as $partida) {
            $gastosFacturas[$partida->id_partida]= DB::table('facturas')
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->whereBetween('facturas.created_at', [$fI, $fF])
            ->select('entrada_articulos.preciofinal')
            ->sum('preciofinal');
            $diferenciasFVP[$partida->id_partida] = $gastosFacturas[$partida->id_partida] - $gastosVales[$partida->id_partida];
        }
        $gastoFinalFac= DB::table('facturas')
        ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->whereBetween('facturas.created_at', [$fI, $fF])
        ->select('entrada_articulos.preciofinal')->sum('preciofinal');
        $diferenciaTotal = $gastoFinalFac - $gastoFinalVal;
        $pdf = PDF::loadView('Reporte.diferencias',  compact(['partidas', 'gastosFacturas', 'gastoFinalFac', 'gastosVales', 'gastoFinalVal', 'diferenciaTotal', 'diferenciasFVP', 'fechaIni1', 'fechaFin1']));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream();
    }

    public function saldos(Request $request){
        $fI = Carbon::parse($request->mes4)->startOfMonth()->toDateString();
        $fF = Carbon::parse($request->mes4)->endOfMonth()->toDateString();
        $fechaIni= Carbon::parse($request->mes4)->startOfMonth()->isoFormat('LL');
        $fechaFin= Carbon::parse($request->mes4)->endOfMonth()->isoFormat('LL');
        $partidas = DB::table('partidas')->orderBy('id_partida', 'asc')->get();
        $anterior_fF = Carbon::parse($fI)->addDay(-1)->endOfMonth()->toDateString();
        $ano = Carbon::parse($fI)->endOfMonth()->addDay()->isoFormat('YYYY');
        $inicio = $ano."-01-01";
        foreach ($partidas as $partida) {
            $inventarioIni[$partida->id_partida]=  DB::table('facturas')
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->where('entrada_articulos.existencia', '>', 0)
            ->WhereBetween('facturas.created_at', [$inicio, $anterior_fF])
            ->where('facturas.confirmed', '>=', 0)
            ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as suma_inv')
            ->get();
            $gastosFacturas[$partida->id_partida]= DB::table('facturas')
            ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->where('facturas.confirmed', '=', 0)
            ->whereBetween('facturas.created_at', [$fI, $fF])
            ->select('articulos.preciofinal')
            ->sum('preciofinal');
            $subtotalPartida[$partida->id_partida]= $gastosFacturas[$partida->id_partida] + $inventarioIni[$partida->id_partida][0]->suma_inv;
            $gastosVales[$partida->id_partida]= DB::table('surtido_entradas')
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
            ->where('articulos.partida_id', '=', $partida->id_partida)
            ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
            ->select('surtido_entradas.total_articulo')
            ->sum('total_articulo');
            $totalPartida[$partida->id_partida]= $subtotalPartida[$partida->id_partida] - $gastosVales[$partida->id_partida];
        }
        $inventarioIniFinal=  DB::table('facturas')
        ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->WhereBetween('facturas.created_at', [$inicio, $anterior_fF])
        ->where('entrada_articulos.existencia', '>', 0)
        ->orWhere('facturas.confirmed', '>=', 0)
        ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) as suma_invF')
        ->get();
        $gastosFacturasTotal= DB::table('facturas')
        ->join('entrada_articulos','facturas.numero_factura' , '=', 'entrada_articulos.factura_id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->whereBetween('facturas.created_at', [$fI, $fF])
        ->where('facturas.confirmed', '=', 0)
        ->select('entrada_articulos.preciofinal')
        ->sum('preciofinal');
        $subTotalFinal = $inventarioIniFinal[0]->suma_invF + $gastosFacturasTotal;
        $gastosValesFinal= DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->whereBetween('vale_surtidos.created_at', [$fI, $fF])
        ->select('surtido_entradas.total_articulo')
        ->sum('total_articulo');
        $inventarioFinal = $subTotalFinal - $gastosValesFinal;
        $pdf = PDF::loadView('Reporte.saldo', compact(['partidas', 'fechaIni', 'fechaFin','inventarioFinal', 'subTotalFinal', 'gastosValesFinal','gastosFacturasTotal','inventarioIniFinal', 'totalPartida', 'subtotalPartida', 'gastosVales', 'inventarioIni', 'gastosFacturas']));
        $pdf->set_paper('a4','landscape');
        return $pdf->stream();
    }
    public function comparativo(Request $request){
        $iniI = Carbon::parse($request->mes)->startOfMonth()->toDateString();
        $finF = Carbon::parse($request->mes)->endOfMonth()->toDateString();
        $fechaIni= Carbon::parse($request->mes)->startOfMonth()->isoFormat('LL');
        $fechaFin= Carbon::parse($request->mes)->endOfMonth()->isoFormat('LL');
        $idP = $request->partida;
        $partida = Partida::findOrFail($idP);
        $recursos = DB::table('origen_recursos')->orderBy('id_origen', 'asc')->get();
        $anterior_fF = Carbon::parse($iniI)->addDay(-1)->endOfMonth()->toDateString();
        $ano = Carbon::parse($iniI)->endOfMonth()->addDay()->isoFormat('YYYY');
        $inicio = $ano."-01-01";
        
        $query1 = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->get();
        $entradas_general = $query1->unique('precio');
        $total_f = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('entrada_articulos.existencia', '>', 0)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) AS total_f')
        ->get();
        $inventarios = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->WhereBetween('facturas.created_at', [$inicio, $anterior_fF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('facturas.confirmed', '>=', 0)
        ->where('entrada_articulos.existencia', '>', 0)
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id', 'facturas.confirmed')
        ->orderBy('entrada_articulos.id','asc')->get();
        $entradas = DB::table('entrada_articulos')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('facturas.confirmed', '=', 0)
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id', 'facturas.confirmed')
        ->orderBy('entrada_articulos.id','asc')->get();

        $articulos = DB::table('articulos')
        ->where('partida_id', '=', $idP)
        ->orderBy('id', 'asc')->get();
        $surtidoEntradas = DB::table('surtido_entradas')->orderBy('id_surtido', 'asc')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
        ->get();
        foreach ($recursos as $recurso) {
            foreach ($articulos as $articulo) {
                foreach ($query1 as $quer) {
                    if($articulo->id == $quer->articulo_id){
                        if ($recurso->id_origen == $quer->recurso_id) {
                            $prueba0[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '=', $quer->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'facturas.recurso_id')
                            ->selectRaw('SUM(entrada_articulos.existencia) AS suma_0')
                            ->get();
                            $prueba01[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '!=', $quer->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'facturas.recurso_id')
                            ->selectRaw('SUM(entrada_articulos.existencia) AS suma_1')
                            ->get();
                            $salida_vales[$recurso->id_origen][$articulo->id]=DB::table('surtido_entradas')
                            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('entrada_articulos.precio', '=', $quer->precio)
                            ->select('entrada_articulos.id', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'articulos.nombre_articulo')
                            ->selectRaw('SUM(surtido_entradas.cantidad) AS cantidad_salidas')
                            ->get();
                        }
                        $salida_vales1[$recurso->id_origen][$articulo->id]=DB::table('surtido_entradas')
                        ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                        ->where('entrada_articulos.precio', '!=', $quer->precio)
                        ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
                        ->select('entrada_articulos.id', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'articulos.nombre_articulo')
                        ->selectRaw('SUM(surtido_entradas.cantidad) AS cantidad_salidas1')
                        ->get();
                    }   
                } 
                
                    $inventario_01[$recurso->id_origen][$articulo->id][0]= null;
                    $inventario_0[$recurso->id_origen][$articulo->id][0]= null;
                foreach ($inventarios as $inventario) {
                    if($articulo->id == $inventario->articulo_id){
                        $inventario_0[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('entrada_articulos.precio', '=', $inventario->precio)
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('facturas.confirmed', '>=', 0)
                        ->where('articulos.id', '=', $articulo->id)
                        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
                        ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                        ->selectRaw('SUM(entrada_articulos.existencia) AS inventario_0')
                        ->get();
                        $inventario_01[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('articulos.id', '=', $articulo->id)
                        ->where('entrada_articulos.precio', '!=', $inventario->precio)
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('facturas.confirmed', '>=', 0)
                        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
                        ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                        ->selectRaw('SUM(entrada_articulos.existencia) AS inventario_01')
                        ->get();
                    }
                }
                    $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]= null;
                    $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]= null;
                foreach ($entradas as $entrada) {
                    if($articulo->id == $entrada->articulo_id){
                        if ($recurso->id_origen == $entrada->recurso_id) {
                            $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '=', $entrada->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.partida_id', '=', $idP)
                            ->where('facturas.confirmed', '=', 0)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                            ->selectRaw('SUM(entrada_articulos.cantidad) AS suma_existencia0')
                            ->get();
                            $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '!=', $entrada->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.partida_id', '=', $idP)
                            ->where('facturas.confirmed', '=', 0)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                            ->selectRaw('SUM(entrada_articulos.cantidad) AS suma_existencia01')
                            ->get();
                        }
                    }
                }
            }
        }
        //dd($inventario_01);
        $pdf = PDF::loadView('Reporte.comparativo', compact(['cantidad_existencia_recursoE', 'prueba0', 'prueba01', 'salida_vales', 'salida_vales1','recursos', 'partida', 'fechaIni', 'fechaFin', 'articulos', 'inventarios', 'query1', 'cantidad_existencia_recursoE', 'cantidad_existencia_recursoE1', 'inventario_01', 'inventario_0', 'total_f']));
        $pdf->set_paper('a4','landscape');
        return $pdf->stream();
    }
    public function movimientos(Request $request){
        $iniI = Carbon::parse($request->mes_movimiento)->startOfMonth()->toDateString();
        $finF = Carbon::parse($request->mes_movimiento)->endOfMonth()->toDateString();
        $fechaIni= Carbon::parse($request->mes_movimiento)->startOfMonth()->isoFormat('LL');
        $fechaFin= Carbon::parse($request->mes_movimiento)->endOfMonth()->isoFormat('LL');
        $idP = $request->partida_movimiento;
        $partida = Partida::findOrFail($idP);
        $recursos = DB::table('origen_recursos')->orderBy('id_origen', 'asc')->get();
        $anterior_fF = Carbon::parse($iniI)->addDay(-1)->endOfMonth()->toDateString();
        $ano = Carbon::parse($iniI)->endOfMonth()->addDay()->isoFormat('YYYY');
        $inicio = $ano."-01-01";
        $query1 = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->get();
        $entradas_general = $query1->unique('precio');
        $total_f = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('entrada_articulos.existencia', '>', 0)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) AS total_f')
        ->get();
        $inventarios = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('entrada_articulos.existencia', '>', 0)
        ->where('facturas.confirmed', '>=', 0)
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id', 'facturas.confirmed')
        ->orderBy('entrada_articulos.id','asc')->get();

        $entradas = DB::table('entrada_articulos')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('facturas.confirmed', '=', 0)
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id', 'facturas.confirmed')
        ->orderBy('entrada_articulos.id','asc')->get();
        $total_e1f = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('facturas.confirmed', '=', 0)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->selectRaw('SUM(entrada_articulos.cantidad * entrada_articulos.precio) AS total_ef01')
        ->get();
        $total_if = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
        ->where('articulos.partida_id', '=', $idP)
        ->where('facturas.confirmed', '>=', 0)
        ->orderBy('entrada_articulos.id','asc')
        ->select('entrada_articulos.cantidad', 'facturas.recurso_id', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'entrada_articulos.articulo_id')
        ->selectRaw('SUM(entrada_articulos.existencia * entrada_articulos.precio) AS total_if')
        ->get();
        $total_s1f = DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->where('articulos.partida_id', '=', $idP)
        ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
        ->selectRaw('SUM(surtido_entradas.total_articulo) AS total_s1f')
        ->get();
        $articulos = DB::table('articulos')
        ->where('partida_id', '=', $idP)
        ->orderBy('id', 'asc')->get();
        $surtidoEntradas = DB::table('surtido_entradas')->orderBy('id_surtido', 'asc')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
        ->get();
        $total_e1 = 0;
        $total_e = 0;
        foreach ($recursos as $recurso) {
            foreach ($articulos as $articulo) {
                foreach ($query1 as $quer) {
                    if($articulo->id == $quer->articulo_id){
                        if ($recurso->id_origen == $quer->recurso_id) {
                            $prueba0[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '=', $quer->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'facturas.recurso_id')
                            ->selectRaw('SUM(entrada_articulos.existencia) AS suma_0')
                            ->get();
                            $total_p0[$recurso->id_origen][$articulo->id]= $prueba0[$recurso->id_origen][$articulo->id][0]->suma_0 * $prueba0[$recurso->id_origen][$articulo->id][0]->precio;
                            $prueba01[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->where('entrada_articulos.precio', '!=', $quer->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->whereBetween('entrada_articulos.created_at', [$inicio, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo', 'facturas.recurso_id')
                            ->selectRaw('SUM(entrada_articulos.existencia) AS suma_1')
                            ->get();
                            $total_p01[$recurso->id_origen][$articulo->id]= $prueba01[$recurso->id_origen][$articulo->id][0]->suma_1 * $prueba01[$recurso->id_origen][$articulo->id][0]->precio;
                            $salida_vales[$recurso->id_origen][$articulo->id]=DB::table('surtido_entradas')
                            ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                            ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('entrada_articulos.precio', '=', $quer->precio)
                            ->select('entrada_articulos.id', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'articulos.nombre_articulo')
                            ->selectRaw('SUM(surtido_entradas.cantidad) AS cantidad_salidas')
                            ->get();
                            $total_s[$recurso->id_origen][$articulo->id]= $salida_vales[$recurso->id_origen][$articulo->id][0]->cantidad_salidas * $salida_vales[$recurso->id_origen][$articulo->id][0]->precio;
                        }
                        $salida_vales1[$recurso->id_origen][$articulo->id]=DB::table('surtido_entradas')
                        ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                        ->where('entrada_articulos.precio', '!=', $quer->precio)
                        ->whereBetween('vale_surtidos.created_at', [$iniI, $finF])
                        ->select('entrada_articulos.id', 'entrada_articulos.precio', 'surtido_entradas.cantidad', 'articulos.nombre_articulo')
                        ->selectRaw('SUM(surtido_entradas.cantidad) AS cantidad_salidas1')
                        ->get();
                        $total_s1[$recurso->id_origen][$articulo->id]= $salida_vales1[$recurso->id_origen][$articulo->id][0]->cantidad_salidas1 * $salida_vales1[$recurso->id_origen][$articulo->id][0]->precio;
                    }   
                } 
                
                    $inventario_01[$recurso->id_origen][$articulo->id][0]= null;
                    $inventario_0[$recurso->id_origen][$articulo->id][0]= null;
                foreach ($inventarios as $inventario) {
                    if($articulo->id == $inventario->articulo_id){
                        $inventario_0[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('articulos.id', '=', $inventario->articulo_id)
                        ->where('entrada_articulos.precio', '=', $inventario->precio)
                        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
                        ->where('facturas.confirmed', '>=', 0)
                        ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                        ->selectRaw('SUM(entrada_articulos.existencia) AS inventario_0')
                        ->get();
                        $total_i0[$recurso->id_origen][$articulo->id] = $inventario_0[$recurso->id_origen][$articulo->id][0]->inventario_0 * $inventario_0[$recurso->id_origen][$articulo->id][0]->precio;
                        $inventario_01[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                        ->where('facturas.recurso_id', '=', $recurso->id_origen)
                        ->where('articulos.id', '=', $inventario->articulo_id)
                        ->where('entrada_articulos.precio', '!=', $inventario->precio)
                        ->whereBetween('entrada_articulos.created_at', [$inicio, $anterior_fF])
                        ->where('facturas.confirmed', '>=', 0)
                        ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                        ->selectRaw('SUM(entrada_articulos.existencia) AS inventario_01')
                        ->get();
                        $total_i01[$recurso->id_origen][$articulo->id] = $inventario_01[$recurso->id_origen][$articulo->id][0]->inventario_01 * $inventario_01[$recurso->id_origen][$articulo->id][0]->precio;
                    }
                }
                $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]= null;
                $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]= null;
                foreach ($entradas as $entrada) {
                    if($articulo->id == $entrada->articulo_id){
                        if ($recurso->id_origen == $entrada->recurso_id) {
                            $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '=', $entrada->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.partida_id', '=', $idP)
                            ->where('facturas.confirmed', '=', 0)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                            ->selectRaw('SUM(entrada_articulos.cantidad) AS suma_existencia0')
                            ->get();
                            $total_e[$recurso->id_origen][$articulo->id] = $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]->suma_existencia0 * $cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]->precio;
                            $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id] = DB::table('articulos')
                            ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
                            ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
                            ->where('entrada_articulos.precio', '!=', $entrada->precio)
                            ->where('facturas.recurso_id', '=', $recurso->id_origen)
                            ->where('articulos.partida_id', '=', $idP)
                            ->where('facturas.confirmed', '=', 0)
                            ->where('articulos.clave_articulo', '=', $articulo->clave_articulo)
                            ->whereBetween('entrada_articulos.created_at', [$iniI, $finF])
                            ->select('entrada_articulos.cantidad', 'entrada_articulos.precio', 'entrada_articulos.existencia','articulos.nombre_articulo', 'articulos.nombre_med', 'entrada_articulos.id', 'articulos.clave_articulo')
                            ->selectRaw('SUM(entrada_articulos.cantidad) AS suma_existencia01')
                            ->get();
                            $total_e1[$recurso->id_origen][$articulo->id] = $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->suma_existencia01 * $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->precio;
                        }
                    }
                }
            }
        }
        $pdf = PDF::loadView('Reporte.movimientos', compact(['cantidad_existencia_recursoE', 'prueba0', 'prueba01', 'salida_vales', 'salida_vales1', 'recursos', 'total_e1f', 'total_if', 'total_s1f', 'total_s1f', 'total_if', 'partida', 'fechaIni', 'fechaFin', 'articulos', 'inventarios', 'query1', 'cantidad_existencia_recursoE', 'cantidad_existencia_recursoE1', 'inventario_01', 'inventario_0', 'total_f', 'total_e1', 'total_e', 'total_s1', 'total_s' , 'total_p0', 'total_p01']));
        $pdf->set_paper('legal','landscape');
        return $pdf->stream();
    }
    public function cierre(Request $request){
        try {
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
                ->select('facturas.iva')
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
            ->select('entrada_articulos.articulo_id', 'entrada_articulos.caducidad', 'entrada_articulos.existencia', 'entrada_articulos.cantidad', 'entrada_articulos.precio',  'entrada_articulos.id', 'facturas.recurso_id', 'facturas.iva', 'facturas.proveedor_id')
            ->get();
            foreach ($recursos as $recurso) {
                if ($total_existencia_recurso[$recurso->id_origen][0]->iva != null) {
                    $numerof = "inv/".$ano."/".$recurso->nombre_recurso;
                    $new_factura = new Factura();
                    $new_factura -> fecha = $tomorrow;
                    $new_factura -> numero_factura = $numerof;
                    $new_factura->proveedor_id = 1;
                    $new_factura->iva = $total_existencia_recurso[$recurso->id_origen][0]->iva;
                    $new_factura->imp_iva = 0;
                    $new_factura->imp_total =  $total_existencia_recurso[$recurso->id_origen][0]->suma_recurso;
                    $new_factura->subtotal = 0;
                    $new_factura->confirmed = 1;
                    $new_factura->recurso_id = $recurso->id_origen;
                    $new_factura->created_at = $tomorrow;
                    $new_factura->updated_at = $tomorrow;
                    $new_factura->save();
                    $numerof = null;
                    $foliof = null;
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
        } catch (\Throwable $th) {
        return redirect ('/cierre/mensual')->with('no', 'Algo salío mal');
        }
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