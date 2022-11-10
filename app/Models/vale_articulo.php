<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class vale_articulo extends Model
{
    use HasFactory;
    protected $table = "vale_articulos";
    protected $primaryKey = 'id_pedido';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad',
        'vale_id',
        'articulo_id'
    ];
}
