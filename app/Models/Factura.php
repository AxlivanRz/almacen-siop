<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = "facturas";
    protected $primaryKey = 'id_factura';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'fecha',
        'numero_factura',
        'respaldo_factura',
        'imp_iva',
        'imp_total',
        'iva',
        'subtotal',
        'confirmed',
        'recurso_id',
        'proveedor_id',
    ];
}
