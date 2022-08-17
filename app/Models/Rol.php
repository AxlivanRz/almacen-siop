<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = "rols";
    protected $primaryKey = 'id_rol';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_rol',
        'slug',
    ];
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'rol_usuarios', 'usuario_id', 'rol_id');
    }
}
