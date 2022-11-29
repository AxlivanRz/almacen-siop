<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Vale extends Model
{
    use HasFactory;
    protected $table = "vales";
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'fecha',
        'fecha_aprovado',
        'usuario_id',
        'administrador_id'
    ];
    public function articulos (){
        return $this->belongsToMany(Articulo::class, 'vale_articulos')->withPivot('cantidad');
    }
}
