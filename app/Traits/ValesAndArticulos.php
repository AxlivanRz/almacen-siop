<?php 
namespace App\Traits; 
use App\Models\Vale;
use App\Models\vale_articulo;
use App\Models\Articulo;
trait ValesAndArticulos{
    /**
     * @return mixeds
     */
    public function entradas()
    {
        return $this->belongsToMany(Articulo::class, 'vale_articulos', 'vale_id', 'articulo_id', 'cantidad');
    }  

    public function hasArticulo($articulo)
    {
        if ($this->articulos->contains('clave_articulo', $articulo)){
            return true;
        }
        return false; 
    }
}