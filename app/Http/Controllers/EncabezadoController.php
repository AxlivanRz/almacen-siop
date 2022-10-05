<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EncabezadoFactura;
use App\Models\Factura;
use App\Models\Proveedores;

class EncabezadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encabezados = EncabezadoFactura::paginate(15);
        $facturas = factura::get();
        $proveedores = Proveedores::get();
        return view ('Factura.index', compact(['facturas', 'encabezados', 'proveedores']));
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
        $create = new EncabezadoFactura;
        $create -> fecha = $request->fecha;
        $create -> numero_factura = $request->numerof;
        $create -> folio = $request->folio;
        $create -> respaldo_factura = $request->archivo;
        $create -> proveedor_id = $request->proveedor;
        return redirect('/encabezado');
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
