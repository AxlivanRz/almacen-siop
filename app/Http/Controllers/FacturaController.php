<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntradaArticulo;
use Illuminate\Database\Query\Builder;
use App\Models\OrigenRecurso;
use App\Models\UnidadMedida;
use App\Models\Proveedores;
use App\Models\Articulo;
use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $proveedores = Proveedores::get();
        $busqueda = $request->busqueda;
        if ($busqueda == null) {
            $facturasExis = DB::table('facturas') 
            ->join('entrada_articulos', 'facturas.numero_factura', '=', 'entrada_articulos.factura_id')
            ->where('entrada_articulos.existencia', '>', 0)
            ->select('facturas.*')
            ->orderBy('fecha', 'desc')
            ->groupBy('numero_factura')
            ->paginate(15);        
        }else{
            $facturasExis = DB::table('facturas') 
            ->join('entrada_articulos', 'facturas.numero_factura', '=', 'entrada_articulos.factura_id')
            ->where('entrada_articulos.existencia', '>', 0)
            ->where('facturas.numero_factura', 'LIKE', $busqueda)
            ->select('facturas.*')
            ->orderBy('fecha', 'desc')
            ->groupBy('numero_factura')
            ->paginate(15);      
            $facturas = Factura::where('numero_factura', '=', $busqueda)
            ->paginate(15);
        }
        return view ('Factura.index', compact(['proveedores', 'facturasExis']));
    }

    public function vacias(Request $request)
    {
        $proveedores = Proveedores::get();
        $busqueda = $request->busqueda;
        if ($busqueda == null) {
            $facturasSin = DB::table('facturas') 
            ->join('entrada_articulos', 'facturas.numero_factura', '=', 'entrada_articulos.factura_id')
            ->where('entrada_articulos.existencia', '=', 0)
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                ->from('entrada_articulos')
                ->whereRaw('entrada_articulos.factura_id = facturas.numero_factura')
                ->whereRaw('entrada_articulos.existencia > 0');
            })
            ->select('facturas.*')
            ->orderBy('fecha', 'desc')
            ->groupBy('numero_factura')
            ->paginate(15);
        }else{
            $facturasSin = DB::table('facturas') 
            ->join('entrada_articulos', 'facturas.numero_factura', '=', 'entrada_articulos.factura_id')
            ->where('entrada_articulos.existencia', '=', 0)
            ->where('facturas.numero_factura', 'LIKE', $busqueda)
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                ->from('entrada_articulos')
                ->whereRaw('entrada_articulos.factura_id = facturas.numero_factura')
                ->whereRaw('entrada_articulos.existencia > 0');
            })
            ->select('facturas.*')
            ->orderBy('fecha', 'desc')
            ->groupBy('numero_factura')
            ->paginate(15);
        }
        return view ('Factura.vacia', compact(['proveedores', 'facturasSin']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $medidas =UnidadMedida::get();
        $proveedores = Proveedores::get();
        $origenes = OrigenRecurso::get();
        $inicio = Carbon::now()->startOfMonth()->toDateString();
        $ultimo = Carbon::now()->endOfMonth()->toDateString();
        return view('Factura.create', compact(['medidas', 'proveedores', 'inicio', 'ultimo', 'origenes']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try{
            $request->validate([
                'fecha' => 'required',
                'numerof' => 'required | unique:App\Models\Factura,numero_factura',

            ],
                [
                'fecha.required' => 'Este campo NO puede estar vacío',
                'numerof.required' => 'Este campo NO puede estar vacío',
                'numerof.unique' => 'El número de la factura ya existe',
            ]);
    
            foreach($request->get('articulokey') as $key => $value){
                $entrada_create = new EntradaArticulo();            
                $entrada_create->factura_id = $request->numerof;            
                $entrada_create->cantidad = $request->get('cantidadkey')[$key];
                $entrada_create->descuento = $request->get('descuentokey')[$key];
                $entrada_create->base = $request->get('basekey')[$key];
                $entrada_create->precio = $request->get('preciokey')[$key];
                $entrada_create->preciofinal = $request->get('preciototalkey')[$key];
                $entrada_create->articulo_id = $value;
                $entrada_create->iva = $request->get('iva')[$key];
                $entrada_create->caducidad = $request->get('caducidad')[$key];
                $entrada_create->imp_unitario = $request->get('unitariokey')[$key];
                $entrada_create->existencia = $request->get('cantidadkey')[$key];
                $entrada_create->save();
            }
            $factura_create = new Factura();
            $factura_create -> fecha = $request->fecha;
            $factura_create -> numero_factura = $request->numerof;
        
            if ($request->hasFile('archivo')) {
                $factura_create['respaldo_factura']=$request->file('archivo')->store('uploads', 'public');
            }
            $factura_create->proveedor_id = $request->proveedor;
            $factura_create->imp_iva = $request->impfactura;
            $factura_create->imp_total = $request->total;
            $factura_create->subtotal = $request->subtotal;
            $factura_create->recurso_id = $request->recurso;
            $factura_create->save();
            return redirect ('/factura')->with('exito', 'Se guardo con exito');
        } catch (\Throwable $th) {
            return redirect ('/factura')->with('no', 'Algo salio mal');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factura = Factura::findOrFail($id);
        $proveedores = Proveedores::get();
        $numerof = DB::table('facturas')
        ->select('numero_factura')
        ->where('id_factura', $id)->get();
        $articulos = Articulo::get();
        $origenes = OrigenRecurso::get();
        //$entradas = EntradaArticulo::get();
        $entradas = DB::table('entrada_articulos')->orderBy('id', 'asc')->get();
        return view('Factura.show', compact(['factura', 'entradas', 'proveedores', 'articulos', 'origenes']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $factura = Factura::findOrFail($id);
        $proveedores = Proveedores::get();
        $numerof = DB::table('facturas')
        ->select('numero_factura')
        ->where('id_factura', $id)->get();
        $articulos = Articulo::get();
        $origenes = OrigenRecurso::get();
        //$entradas = EntradaArticulo::get();
        $entradas = DB::table('entrada_articulos')->orderBy('id', 'asc')->get();
        return view('Factura.edit', compact(['factura', 'entradas', 'proveedores', 'articulos', 'origenes']));
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
        try {
            if ($request->get('elimado') != null) {
                foreach($request->get('elimado') as $key1 => $value1){ 
                    $delete = EntradaArticulo::findOrFail($value1);
                    $delete->delete();
                }
            } 
            $edit_factura = Factura::findOrFail($id);
            if ($request->get('articulokey') != null) {
                foreach($request->get('articulokey') as $key => $value){           
                    $numerof = $request->numerof; 
                    $cantidadkey = $request->get('cantidadkey')[$key];
                    $descuentokey = $request->get('descuentokey')[$key];
                    $basekey = $request->get('basekey')[$key];
                    $preciokey = $request->get('preciokey')[$key];
                    $preciofinalkey = $request->get('preciototalkey')[$key];
                    $iva = $request->get('preciototalkey')[$key];
                    $articulokey= $value;
                    if ($request->get('caducidad') != null) {
                        $caducidadkey = $request->get('caducidad')[$key];
                    }
                    $unitariokey = $request->get('unitariokey')[$key];
                    if (isset($request->get('id_entrada')[$key])) {
                        $entrada_id = $request->get('id_entrada')[$key];
                        $entrada = EntradaArticulo::firstOrNew(['id' =>  $entrada_id]);
                        $entrada->factura_id = $numerof;
                        $entrada->cantidad = $cantidadkey;
                        $entrada->descuento = $descuentokey;
                        $entrada->base = $basekey;
                        $entrada->precio = $preciokey;
                        $entrada->iva = $iva;
                        $entrada->preciofinal = $preciofinalkey;
                        $entrada->articulo_id = $articulokey;
                        $entrada->imp_unitario = $unitariokey;
                        $entrada->existencia = $cantidadkey;
                        if( $request->get('caducidad') != null){
                            $entrada->caducidad = $caducidadkey;
                        }
                        $entrada->save();
                    }else{
                        $create = new EntradaArticulo;
                        $create->factura_id = $numerof;
                        $create->cantidad = $cantidadkey;
                        $create->descuento = $descuentokey;
                        $create->base = $basekey;
                        $create->iva = $iva;
                        $create->precio = $preciokey;
                        $create->preciofinal = $preciofinalkey;
                        $create->articulo_id = $articulokey;
                        $create->imp_unitario = $unitariokey;
                        if( $request->get('caducidad') != null){
                            $entrada->caducidad = $caducidadkey;
                        }
                        $create->existencia = $cantidadkey;
                        $create->save();
                    }
                    
                }
            }
            $edit_factura -> fecha = $request->fecha;
            $edit_factura -> numero_factura = $request->numerof;
        
            if ($request->hasFile('archivo')) {
                $edit_factura['respaldo_factura']=$request->file('archivo')->store('uploads', 'public');
            }
            $edit_factura->proveedor_id = $request->proveedor;
            $edit_factura->imp_iva = $request->impfactura;
            $edit_factura->imp_total = $request->total;
            $edit_factura->subtotal = $request->subtotal;
            $edit_factura->recurso_id = $request->recurso;
            $edit_factura->save();
            return redirect ('/factura')->with('exito', 'Se guardo con exito');
        } catch (\Throwable $th) {
             return redirect ('/factura')->with('no', 'Algo salio mal');
        }
    }

}
