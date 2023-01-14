<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioInicial extends Model
{
    use HasFactory;
    protected $table = "inventario_inicials";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'total',
        'fecha',
    ];
}
