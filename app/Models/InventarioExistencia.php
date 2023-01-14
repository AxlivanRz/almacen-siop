<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioExistencia extends Model
{
    use HasFactory;
    protected $table = "inventario_existencias";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'cantidad',
        'existencia',
        'precio_unitario',
        'precio_total',
        'fecha',
        'articulo_id',
    ];
}
