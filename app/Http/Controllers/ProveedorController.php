<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedores;
use Illuminate\Support\Facades\DB;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedores::paginate(15);
        return view('Proveedor.index', compact(['proveedores']));
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
        $create = new Proveedores;
        $create -> razon_social = $request->razon;
        $create -> calle = $request->calle;
        $create -> colonia = $request->colonia;
        $create -> codigo_postal = $request->codigo_postal;
        $create -> poblacion = $request->poblacion;
        $create -> estado = $request->estado;
        $create -> pais = $request->pais;
        $create -> telefono = $request->telefono;
        $create -> email_proveedor = $request->email_proveedor;
        $create->save();
        return redirect('/proveedor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $edit = Proveedores::findOrFail($id);
        $edit -> razon_social = $request->razon;
        $edit -> calle = $request->calle;
        $edit -> colonia = $request->colonia;
        $edit -> codigo_postal = $request->codigo_postal;
        $edit -> poblacion = $request->poblacion;
        $edit -> estado = $request->estado;
        $edit -> pais = $request->pais;
        $edit -> telefono = $request->telefono;
        $edit -> email_proveedor = $request->email_proveedor;
        $edit->save();
        return redirect('/proveedor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Proveedores::findOrFail($id);
        $delete->delete();
        return redirect('/proveedor');
    }
}
