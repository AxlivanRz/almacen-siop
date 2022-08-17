<?php 
namespace App\Traits; 
use App\Models\Rol;
use App\Models\RolUsuario;
use App\Models\User;
trait HasRolesAndPermissions{
    /**
     * @return mixeds
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuarios', 'usuario_id', 'rol_id');
    } 

    public function hasRol($rol)
    {
        if ($this->roles->contains('slug', $rol)){
            return true;
        }
        return false; 
    }
}