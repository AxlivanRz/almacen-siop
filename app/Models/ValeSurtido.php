<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeSurtido extends Model
{
    use HasFactory, SurtirAndEntrada;
    protected $table = "vale_surtidos";
    protected $primaryKey = 'id_surtido';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total',
        'fecha',
        'vale_id',  
        'capturista_id'
    ];
}
