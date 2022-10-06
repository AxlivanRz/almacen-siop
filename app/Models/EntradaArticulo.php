<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaArticulo extends Model
{
    use HasFactory;
    protected $table = "entrada_articulos";
    protected $primaryKey = 'id_precio_entrada';
    public $incrementing = true;
    public $timestamps = true; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad',
        'descuento',
        'base',
        'precio',
        'imp_unitario',
        'articulo_id',
        'encabezado_id', 
    ];
}
