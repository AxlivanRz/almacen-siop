<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\EntradaArticulo;
use App\Models\OrigenRecurso;
use App\Models\Departamento;
use App\Models\ValeSurtido;
use App\Models\Factura;
use App\Models\Partida;
use App\Models\Area;
use App\Models\User;
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
        return view('Reporte.indexDiario', compact('recursos'));
    }
    public function pdf(Request $request){
        $fI = $request->inicio;
        $fF = $request->final;
        $partidas = DB::table('partidas')->orderBy('id_partida', 'asc')->get();
        $areas = DB::table('areas')->orderBy('id_area', 'asc')->get();
        if ($request->recurso == 0) {
            foreach ($partidas as $partida) {
                $gastosPartida[$partida->id_partida]= DB::table('surtido_entradas')
                ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
                ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
                ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
                ->where('articulos.partida_id', '=', $partida->id_partida)
                ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
                ->select('surtido_entradas.total_articulo')
                ->sum('total_articulo');
            } 
            foreach ($areas as $area) {
                $gastosArea[$area->id_area]= DB::table('surtido_entradas')
                ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')->join('vales', 'vale_surtidos.vale_id', '=', 'vales.id')
                ->join('areas', 'vales.area_id', '=', 'areas.id_area')
                ->where('areas.id_area', '=', $area->id_area)
                ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
                ->select('surtido_entradas.total_articulo')
                ->sum('total_articulo');
            }
            $gastoFinal= DB::table('surtido_entradas')
            ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
            ->whereBetween('vale_surtidos.fecha', [$fI, $fF])->select('surtido_entradas.total_articulo')->sum('total_articulo');
            foreach ($areas as $area) {
                foreach ($partidas as $partida) {
                    $gastosV2 = "Select SUM(total_articulo) as suma, AR.nombre_area, P.id_partida,  P.nombre_partida from surtido_entradas as SE 
                    inner join vale_surtidos as VS on SE.vale_surtido_id = VS.id 
                    inner join vales as V on VS.vale_id = V.id
                    inner join entrada_articulos as EA on SE.entrada_articulo_id = EA.id
                    inner join articulos as A on EA.articulo_id = A.id 
                    inner join areas as AR on V.area_id = AR.id_area 
                    inner join partidas as P on A.partida_id = P.id_partida
                    where A.partida_id = ".$partida->id_partida." && V.area_id = ".$area->id_area.";";
                    $gastos [$area->id_area][$partida->id_partida]= DB::select($gastosV2);
                }
            }
            $pdf = PDF::loadView('Reporte.diario',  compact(['partidas', 'areas', 'gastos', 'gastosPartida', 'gastosArea', 'gastoFinal']));
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
            ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
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
            ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
            ->select('surtido_entradas.total_articulo')
            ->sum('total_articulo');//OR
        }
        $gastoFinal= DB::table('surtido_entradas')//OR
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->join('entrada_articulos','surtido_entradas.entrada_articulo_id' , '=', 'entrada_articulos.id')
        ->join('facturas', 'entrada_articulos.factura_id', '=', 'facturas.numero_factura')
        ->where('facturas.recurso_id', '=', $idOR)
        ->whereBetween('vale_surtidos.fecha', [$fI, $fF])
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
                && FA.recurso_id = ".$idOR." && VS.fecha between cast('".$fI."' as date) and cast('".$fF."' as date);";
                $gastos [$area->id_area][$partida->id_partida]= DB::select($gastosV2);
            }
        }//OR
        $pdf = PDF::loadView('Reporte.diario',  compact(['partidas', 'areas', 'gastos', 'gastosPartida', 'gastosArea', 'gastoFinal']));
        $pdf->set_paper ('a4','landscape');
        return $pdf->stream();
        //return view ('Articulo.pdf', compact('articulos'));
    }
    public function prueba()
    {
        return view ('Reporte.pruebas', compact(['partidas', 'areas', 'gastos', 'gastosPartida', 'gastosArea', 'gastoFinal']));
    }
    public function crossArea(){
        $crossAPs = DB::table('areas')
        ->orderBy('areas.id_area', 'asc')
        ->crossJoin('partidas')
        ->orderBy('partidas.id_partida', 'asc')
        ->get();
        return $crossAPs;
    }
    public function index()
    {
        //
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
