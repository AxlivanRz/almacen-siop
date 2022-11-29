<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surtido_entrada extends Model
{
    use HasFactory;
    protected $table = "surtido_entradas";
    protected $primaryKey = 'id_surtido';
    public $incrementing = true;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad',
        'entrada_articulo_id',
        'vale_surtido_id'
    ];
}

    
   