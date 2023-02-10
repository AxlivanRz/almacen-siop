<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\EntradaArticulo;
use App\Models\surtido_entrada;
use App\Models\OrigenRecurso;
use App\Models\ValeSurtido;
use App\Models\Factura;
use App\Models\Articulo;
use App\Models\Partida;
use App\Models\Area;
use App\Models\User;
use App\Models\Vale;
class ComparativoExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $entradas;
    protected $salidas;
    public function __construct($entradas = null, $salidas = null){
        $this->entradas = $entradas;
        $this->salidas = $salidas;
    }
    public function view(): View
    {
        return view('Excel.comparativo',[
            'entradas' => $this->entradas ?: EntradaArticulo::all(),
            'salidas' => $this->salidas ?: surtido_entrada::all(),
            'vales_surtidos' => ValeSurtido::all(),
            'recursos' => OrigenRecurso::all(),
            'articulos' => Articulo::all(),
            'partidas' => Partida::all(),
            'facturas' => Factura::all(),
            'vales' => Vale::all(),
            'areas' => Area::all(),
            'users' => User::all()
        ]);
    }
}
