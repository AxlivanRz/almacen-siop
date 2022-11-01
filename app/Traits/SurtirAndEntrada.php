<?php 
namespace App\Traits; 
use App\Models\EntradaArticulo;
use App\Models\ValeSurtido;
use App\Models\surtido_entrada;
trait SurtirAndEntrada{
    /**
     * @return mixeds
     */
    public function entradas()
    {
        return $this->belongsToMany(EntradaArticulo::class, 'surtido_entradas', 'surtido_id', 'entrada_id', 'cantidad');
    }  

    public function hasEntrada($entrada)
    {
        if ($this->entradas->contains('id_precio_entrada', $entrada)){
            return true;
        }
        return false; 
    }
}