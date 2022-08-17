<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
    use HasFactory;
    protected $table = "rol_usuarios";
    protected $primaryKey = ['usuario_id', 'rol_id'];
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       
    ];
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'users', 'usuario_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rols', 'rol_id');
    } 
}
