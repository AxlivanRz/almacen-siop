<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class vale_articulo extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = "vale_articulos";
    protected $primaryKey = ['vale_id', 'articulo_id'];
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
    public function vales()
    {
        return $this->belongsToMany(Vale::class, 'vales', 'vale_id');
    }
    public function articulos()
    {
        return $this->belongsToMany(Articulo::class, 'articulos', 'articulo_id');
    } 
}
