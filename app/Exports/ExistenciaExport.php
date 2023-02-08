<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\EntradaArticulo;
use App\Models\OrigenRecurso;
use App\Models\Factura;
use App\Models\Articulo;
use App\Models\Partida;

class ExistenciaExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $entradas;
    public function __construct($entradas = null){
        $this->entradas = $entradas;
    }
    public function view(): View
    {
        return view('Excel.existencias',[
            'entradas' => $this->entradas ?: EntradaArticulo::all(),
            'facturas' => Factura::all(),
            'recursos' => OrigenRecurso::all(),
            'articulos' => Articulo::all(),
            'partidas' => Partida::all()
        ]);
    }
}
