<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;
    protected $table = "partidas";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_partida',
        'descripcion_partida',
        'abreviado',
    ];
    public function articulos (){
        return $this->belongsTo(Articulo::class, 'articulos');
    }
}
