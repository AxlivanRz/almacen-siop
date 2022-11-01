<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surtido_entrada extends Model
{
    use HasFactory;
    protected $table = "surtido_entradas";
    protected $primaryKey = ['surtido_id', 'entrada_id'];
    public $incrementing = true;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad'
    ];
    public function surtir()
    {
        return $this->belongsToMany(ValeSurtido::class, 'vale_surtidos', 'surtido_id');
    }
    public function entradas()
    {
        return $this->belongsToMany(EntradaArticulo::class, 'entrada_articulos', 'entrada_id');
    }

}

    
   