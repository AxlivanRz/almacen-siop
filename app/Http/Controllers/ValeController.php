<?php

namespace App\Http\Controllers;
use App\Models\Vale;
use App\Models\Articulo;
use App\Models\EntradaArticulo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ValeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vales = Vale::paginate(15);
        return view('Vale.index', compact('vales'));
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entradas = EntradaArticulo::get();
        return view('Vale.create', compact(['entradas']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $createVale = new Vale;
        $date = Carbon::now()->isoFormat('YYYY/MM/DD, h:mm:ss a');
        $createVale->status = 1;
        $createVale->fecha = $date;
        $createVale->fecha_aprovado = null;
        if (Gate::allows('isVal')) {
            $createVale->usuario_id = $request->user()->id_usuario;
            $createVale->administrador_id = null;
        }
        $createVale->save();
        if ($request->get('articulokey') !=null) { 
            foreach($request->get('articulokey') as $key => $value){
                $cantidad = $request->get('cantidadkey')[$key];
                $createVale->articulos()->attach( $value, ['cantidad' => $cantidad]);
                $createVale->save();
            }
        }
        return redirect ('/vale'); 
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
        if (Gate::allows('isVal') && Auth::user()->id_usuario == $editVale->usuario_id && $editVale->status == 1) {
            $editVale = Vale::findOrFail($id);
            $editVale->status = 1;
            $editVale->save();
            $editVale->articulos()->detach();
            if ($request->articulokey !=null) { 
                foreach($request->get('articulokey') as $key => $value){
                    $editVale->articulos()->attach($value, ['cantidad' => $request->get('cantidad')]);
                    $editVale->save();
                }
            }
            return $editVale;
        } 
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
