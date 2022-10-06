<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $table = "articulos";
    protected $primaryKey = 'id_articulo';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clave_articulo',
        'nombre_articulo',
        'foto_articulo',
        'ubicacion',
        'observaciones',
        'medida_id',
        'nombre_med',
        'partida_id',
    ];
}
