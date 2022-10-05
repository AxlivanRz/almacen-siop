<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncabezadoFactura extends Model
{
    use HasFactory;
    protected $table = "encabezado_facturas";
    protected $primaryKey = 'id_encabezado_factura';
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
        'folio',
        'respaldo_factura',
        'proveedor_id',
    ];
}
