<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;
    protected $table = "proveedores";
    protected $primaryKey = 'id_proveedor';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'razon_social',
        'nombre_empresa',
        'calle',
        'colonia',
        'codigo_postal',
        'poblacion',
        'estado',
        'pais',
        'telefono',
        'email_proveedor',
    ];
}
