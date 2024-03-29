<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedores;
use Illuminate\Support\Facades\DB;
class ProveedorController extends Controller
{
    
    public function index()
    {
        $proveedores = Proveedores::paginate(15);
        return view('Proveedor.index', compact(['proveedores']));
    }

    public function store(Request $request)
    {
        try {
            $create = new Proveedores;
            $create -> razon_social = $request->razon;
            $create -> nombre_empresa = $request->empresa;
            $create -> calle = $request->calle;
            $create -> colonia = $request->colonia;
            $create -> codigo_postal = $request->codigo_postal;
            $create -> poblacion = $request->poblacion;
            $create -> estado = $request->estado;
            $create -> pais = $request->pais;
            $create -> telefono = $request->telefono;
            $create -> email_proveedor = $request->email_proveedor;
            $create->save();
            return redirect('/proveedor')->with('exito',  $create->razon_social.' se guardo con éxito');
        } catch (\Throwable $th) {
            return redirect('/proveedor')->with('no', 'Algo salio mal');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $edit = Proveedores::findOrFail($id);
            $edit -> razon_social = $request->razon;
            $edit -> nombre_empresa = $request->empresa;
            $edit -> calle = $request->calle;
            $edit -> colonia = $request->colonia;
            $edit -> codigo_postal = $request->codigo_postal;
            $edit -> poblacion = $request->poblacion;
            $edit -> estado = $request->estado;
            $edit -> pais = $request->pais;
            $edit -> telefono = $request->telefono;
            $edit -> email_proveedor = $request->email_proveedor;
            $edit->save();
            return redirect('/proveedor')->with('exito',  $edit->razon_social.' se guardo con éxito');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/proveedor')->with('no', 'Algo salio mal');
        }
    }

    public function destroy($id)
    {
        try {
            $delete = Proveedores::findOrFail($id);
            $delete->delete();
            return redirect('/proveedor')->with('exito',  $delete->razon_social.' se elimino correctamente');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/proveedor')->with('no', 'Algo salio mal');
        }
    }
}
