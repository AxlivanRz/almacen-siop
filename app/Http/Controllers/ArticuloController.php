<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Articulo;
use App\Models\UnidadMedida;
use App\Models\EntradaArticulo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use PDF;

class ArticuloController extends Controller
{
   
    public function index(Request $request)
    {

       if ($request->ajax()) {
        $articulo = DB::table('articulos')
        ->join('partidas', 'articulos.partida_id', '=', 'partidas.id')
        ->where('articulos.id', $request->idArtAjx)
        ->select('partidas.descripcion_partida', 'articulos.*')
        ->get();
        return  $articulo;
        }
        $medidas= UnidadMedida::all();
        $partidas= Partida::all();
        return view('Articulo.index', compact(['medidas', 'partidas']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required | unique:App\Models\Articulo,clave_articulo',
        ],
            [
            'clave.unique' => 'La clave del Articulo ya existe',
        ]);
        try {
            $create = new Articulo;
            $create -> nombre_articulo = $request->nombreAr;
            $create -> clave_articulo = $request->clave;
            $create -> ubicacion = $request->ubicacion;
            $create -> observaciones = $request->observaciones;
            $create -> medida_id = $request->medida;
            $idmed = $request->medida;
            $nombremed = UnidadMedida::findOrFail($idmed);
            $create -> nombre_med = $nombremed->nombre_medida;
            $create -> partida_id = $request->partida;
            if ($request->hasFile('foto_articulo')) {
                $create['foto_articulo']=$request->file('foto_articulo')->store('uploads', 'public');
            }
            $create->save();
            return redirect('/articulo')->with('exito',  $create->nombre_articulo.' se guardo con éxito');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/articulo')->with('no', 'Algo salio mal');
        }
    }

    public function edit($id)
    {    
        $articulo = Articulo::findOrFail($id);
        $medidas= UnidadMedida::all();
        $partidas= Partida::all();
        return view('Articulo.edit', compact(['medidas', 'partidas', 'articulo']));
    }

    public function update(Request $request, $id)
    {
        $edit1 = Articulo::findOrFail($id);
        $request->validate([
            
            'clave' => Rule::unique('articulos', 'clave_articulo')->ignore($edit1->id),
        ],
            [
            'clave.unique' => 'La clave del Articulo ya existe',
        ]);
        try {
            $edit = Articulo::findOrFail($id);
            $edit -> nombre_articulo = $request->nombreAr;
            $edit -> clave_articulo = $request->clave;
            $edit -> ubicacion = $request->ubicacion;
            $edit -> observaciones = $request->observaciones;
            $edit -> medida_id = $request->medida;
            $idmed = $request->medida;
            $nombremed = UnidadMedida::findOrFail($idmed);
            $edit -> nombre_med = $nombremed->nombre_medida;
            if ($request->partida !=null) {
                $edit -> partida_id = $request->partida;
            }
            if ($request->hasFile('foto')) {
                $edit['foto_articulo']=$request->file('foto')->store('uploads', 'public');
            }
            $edit->save();
            return redirect('/articulo')->with('exito',  $edit->nombre_articulo.' se guardo con éxito');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/articulo')->with('no', 'Algo salio mal');
        }
    }

    public function destroy($id)
    {
        try {
            $delete = Articulo::findOrFail($id); 
            $delete->delete();
            return redirect('/articulo')->with('exito',  $delete->nombre_articulo.' se elimino correctamente');
        } catch (\Throwable $th) {
            return redirect('/articulo')->with('no',  'Algo salio mal');
        }
    }

    public function getArticulo(){
        $articulos[] = array();
        $query = Articulo::get();
        return ($query);
    }
    public function tblArticulo(){
        $articulos = Articulo::with('partidas')->get();
        return datatables()->eloquent(Articulo::with('partidas'))->addColumn('actions', function ($articulo) {
            return 
            '<a class="btn btn-sm btn-primary"  href="/articulo/'.$articulo->id.'/edit" >'.
                '<i class="fa-regular fa-pen-to-square"></i>' .
                '</a>'. '&nbsp'.
            '<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" onclick="idArt(this);" id = "'.$articulo->id.'" data-bs-target="#articuloShow">'.
                '<i class="fas fa-eye"></i>'.
           ' </button>';
        })->rawColumns(['actions'])->toJson();
    }

    public function getExistencia(){ 
        $articulos[] = array();
        $query1 = DB::table('articulos')
        ->join('entrada_articulos', 'articulos.id', '=', 'entrada_articulos.articulo_id')
        ->orWhere('entrada_articulos.existencia', '>',  0)
        ->select('articulos.id','articulos.nombre_articulo', 'articulos.nombre_med')
        ->get();
        $query2 = $query1->unique('nombre_articulo');
        return ($query2);
    }
}
