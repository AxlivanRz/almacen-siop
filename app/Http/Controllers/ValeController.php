<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\EntradaArticulo;
use App\Models\Departamento;
use App\Models\ValeSurtido;
use App\Models\Articulo;
use App\Models\Vale;
use App\Models\User;
use Carbon\Carbon;

class ValeController extends Controller
{
    public function index()
    {
        $vales = Vale::get();
        return view('Vale.index', compact('vales'));
    }
 
    public function create()
    {
        return view('Vale.create');
    }

    public function store(Request $request)
    {
        try {
            $createVale = new Vale;
            $date = Carbon::now();
            $createVale->status = 1;
            $createVale->fecha = $date;
            $createVale->fecha_aprovado = null;
            if (Gate::allows('isVal')) {
                $createVale->usuario_id = $request->user()->id_usuario;
                $createVale->administrador_id = null;
            }
            if($request->user()->area_id != null){
                $createVale->area_id = $request->user()->area_id;
            }
            if($request->user()->departamento_id != null){
                $departamento = Departamento::findOrFail($request->user()->departamento_id);
                $createVale->area_id = $departamento->area_id;
            }
            $createVale->save();
            if ($request->get('articulokey') !=null) { 
                foreach($request->get('articulokey') as $key => $value){
                    $cantidad = $request->get('cantidadkey')[$key];
                    $createVale->articulos()->attach($value, ['cantidad' => $cantidad]);
                    $createVale->save();
                }
            }
            return redirect ('/vale')->with('exito', 'Se guardo con éxito el vale N°'.$createVale->id);
        } catch (\Throwable $th) {
            return redirect ('/vale')->with('no', 'Algo salio mal');
        }
            
    }

    public function show($id)
    {
        $vale = Vale::findOrFail($id);
        $idSurtido = DB::table('vale_surtidos')
        ->where('vale_id', '=', $id)
        ->select('id')
        ->get();
        $nid = null;
        foreach ($idSurtido as $idw) {
            $nid = $idw->id;
        }
        $entradas = DB::table('entrada_articulos')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->get();

        $valeArticulos = $vale->articulos;
        $usuarios = User::get();
        $surtido = ValeSurtido::findOrFail($nid);
        $queryEFAs = DB::table('surtido_entradas')
        ->where('vale_surtido_id', '=', $nid)
        ->join('entrada_articulos', 'surtido_entradas.entrada_articulo_id', '=', 'entrada_articulos.id')
        ->join('articulos', 'entrada_articulos.articulo_id', '=', 'articulos.id')
        ->select('articulos.clave_articulo', 'surtido_entradas.cantidad', 'entrada_articulos.id')
        ->get();
        return view('Vale.show', compact(['vale', 'entradas', 'valeArticulos', 'queryEFAs', 'surtido', 'usuarios'])); 
    }

    public function edit($id)
    {
        $vale = Vale::findOrFail($id);
        $entradas = EntradaArticulo::get();
        $valeArticulos = $vale->articulos;
        $diferentes = DB::table('vale_articulos')
        ->where('vale_id', '=', $id)
        ->join('articulos', 'vale_articulos.articulo_id', '!=', 'articulos.id')
        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        ->where('entrada_articulos.existencia', '>',  0)
        ->select('articulos.id','articulos.nombre_articulo', 'articulos.nombre_med')
        ->get();
        $dif2 = $diferentes->unique('nombre_articulo');
        return view('Vale.edit', compact(['vale', 'entradas', 'valeArticulos', 'dif2'])); 

    }

    public function update(Request $request, $id)
    {
        try {
            $editVale = Vale::findOrFail($id);
            if (Gate::allows('isVal') && Auth::user()->id_usuario == $editVale->usuario_id && $editVale->status == 1) {
                $editVale->status = 1;
                $editVale->save();
                $editVale->articulos()->detach();
                if ($request->articulokey !=null) { 
                    foreach($request->get('articulokey') as $key => $value){
                        $cantidad = $request->get('cantidadkey')[$key];
                        $editVale->articulos()->attach($value, ['cantidad' => $cantidad]);
                        $editVale->save();
                    }
                }
                return redirect('/vale')->with('exito', 'Se edito con éxito el vale N°'.$editVale->id);
            } 
        } catch (\Throwable $th) {
            return redirect('/vale')->with('no', 'Algo salio mal');

        }
    }
   
    public function destroy($id)
    {
        //
    }
    public function Vsubmit($id)
    {
        $submitVale = Vale::findOrFail($id);
        $submitVale->status = 3;
        $submitVale->save();
        return redirect('/vale');
    }
}
