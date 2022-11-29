<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValeSurtido extends Model
{
    use HasFactory;
    protected $table = "vale_surtidos";
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
        'capturista_id',
        'vale_id'
    ];
    public function entradas (){
        return $this->belongsToMany(EntradaArticulo::class, 'surtido_entradas')->withPivot('cantidad');
    }
}
