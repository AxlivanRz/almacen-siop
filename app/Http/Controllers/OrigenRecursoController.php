<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrigenRecurso;
use Illuminate\Support\Facades\DB;
class OrigenRecursoController extends Controller
{
    
    public function index()
    {
        $datos['recursos'] = OrigenRecurso::paginate(10);
        return view ('Recurso.index', $datos);
    }

    public function store(Request $request)
    {
        $create = new OrigenRecurso; 
        $create -> nombre_recurso = $request->nombre_recurso;
        $create->save();
        return redirect('/recurso');
    }

    public function update(Request $request, $id)
    {
        $edit = OrigenRecurso::findOrFail($id);
        $edit -> nombre_recurso = $request->nombre_recurso;
        $edit->save();
        return redirect('/recurso');
    }

    public function destroy($id)
    {
        $delete = OrigenRecurso::findOrFail($id);
        $delete->delete();
        return redirect('/recurso');
    }
}
