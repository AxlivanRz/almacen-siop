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
        'imp_iva',
        'imp_total',
        'imp_unitario',
        'imp_factura',
        'articulo_id',
        'encabezado_id',
    ];
}
