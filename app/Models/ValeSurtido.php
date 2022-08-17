<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeSurtido extends Model
{
    use HasFactory;
    protected $table = "vale_surtidos";
    protected $primaryKey = 'id_surtido';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'total',
        'fecha',
        'articulo_id',
        'vale_id',
    ];
}
