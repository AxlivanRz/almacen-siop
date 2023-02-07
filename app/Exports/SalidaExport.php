<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\surtido_entrada;
use App\Models\EntradaArticulo;
use App\Models\OrigenRecurso;
use App\Models\ValeSurtido;
use App\Models\Articulo;
use App\Models\Factura;
use App\Models\Partida;
use App\Models\Vale;

class SalidaExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function view(): View
    {
        return view('Excel.salidas',[
            'entradas' => EntradaArticulo::all(),
            'facturas' => Factura::all(),
            'recursos' => OrigenRecurso::all(),
            'articulos' => Articulo::all(),
            'partidas' => Partida::all(),
            'vales' => Vale::all(),
            'vales_surtidos' => ValeSurtido::all(),
            'salidas' => surtido_entrada::all()
        ]);
    }
}
