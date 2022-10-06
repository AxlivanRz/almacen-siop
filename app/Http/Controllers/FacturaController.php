<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\EncabezadoFactura;
use App\Models\Factura;
use App\Models\UnidadMedida;
use App\Models\EntradaArticulo;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->get('articulokey') as $key => $value){
            $entrada_create = new EntradaArticulo();            
            $entrada_create->encabezado_id = $request->encabezado_id;            
            $entrada_create->cantidad = $request->get('cantidadkey')[$key];
            $entrada_create->descuento = $request->get('descuentokey')[$key];
            $entrada_create->base = $request->get('basekey')[$key];
            $entrada_create->precio = $request->get('preciokey')[$key];
            $entrada_create->articulo_id = $value;
            $entrada_create->imp_unitario = $request->get('unitariokey')[$key];
            $entrada_create->save();
        }

        $factura_create = new Factura();
        $factura_create->encabezado_id = $request->encabezado_id;
        $factura_create->iva = $request->get('iva');
        $factura_create->imp_iva = $request->get('impfactura');
        $factura_create->imp_total = $request->get('total');
        $factura_create->save();
        return redirect ('/encabezado');
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
    public function formfactura($id)
    {
        $medidas =UnidadMedida::get();
        $encabezado = EncabezadoFactura::findOrFail($id);
        return view('Factura.createfactura', compact(['encabezado', 'medidas']));
    }
}
