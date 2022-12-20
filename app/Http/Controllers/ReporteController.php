<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\EntradaArticulo;
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
        return view('Reporte.indexDiario');
    }
    public function pdf(){
        $mdss = "";
        $gastos  = DB::table('surtido_entradas')
        ->join('vale_surtidos', 'surtido_entradas.vale_surtido_id', '=', 'vale_surtidos.id')
        ->join('vales', 'vale_surtidos.vale_id', '=', 'vales.id')
        ->join('vale_articulos','vales.id' , '=', 'vale_articulos.vale_id')
        ->join('articulos', 'vale_articulos.articulo_id', '=', 'articulos.id')
        ->join('partidas', 'articulos.partida_id' , '=', 'partidas.id_partida')
        ->join('users', 'vales.usuario_id' , '=', 'users.id_usuario')
        ->join('areas', 'users.area_id' , '=', 'areas.id_area')
        ->selectRaw('SUM(DISTINCT vale_surtidos.total)')
        //->select('vales.id','areas.id_area', 'partidas.id_partida')
        ->get();
        
        $partidas = Partida::get();
        $areas = Area::get();
        $pdf = PDF::loadView('Reporte.diario', ['areas'=>$areas, 'partidas'=>$partidas], compact('gastos'));
        $pdf->set_paper ('a4','landscape');
        return $pdf->stream();
        //return view ('Articulo.pdf', compact('articulos'));
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
