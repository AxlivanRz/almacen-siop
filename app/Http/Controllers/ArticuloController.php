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
   
    public function index()
    {
        $partidas = Partida::get();
        $medidas = UnidadMedida::get();
        $articulos = Articulo::paginate(20);
        return view('Articulo.index', compact(['articulos', 'partidas', 'medidas']));
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

    public function searchArt(Request $request){ 
        $busqueda = $request->busqueda;
        error_log("\n|\n|\n" . json_encode(['b0'=>$busqueda,])); //quitar
        if ($busqueda === "") {
            $articulos = DB::table('articulos')
            ->join('partidas', 'articulos.partida_id', '=', 'partidas.id_partida')
            ->select('partidas.nombre_partida', 'articulos.id', 'articulos.clave_articulo', 'articulos.nombre_med', 'articulos.nombre_articulo')
            ->take(15)
            ->get();
            $articulos->all();
            error_log("\n|\n|\n" . json_encode(['b1'=>$busqueda,])); //quitar
        }else {
            if (!empty($busqueda)) {
                $articulos = DB::table('articulos')
                ->join('partidas', 'articulos.partida_id', '=', 'partidas.id_partida')
                ->where('nombre_articulo', 'like', '%'.$busqueda.'%')
                ->select('partidas.nombre_partida', 'articulos.id', 'articulos.clave_articulo', 'articulos.nombre_med', 'articulos.nombre_articulo')
                ->take(15)
                ->get();
                $articulos->all();
                error_log("\n|\n|\n" . json_encode(['b2'=>$busqueda,])); //quitarc
            }
        }
        return $articulos;
    }
}
