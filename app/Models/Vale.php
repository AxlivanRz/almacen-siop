<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ValesAndArticulos;
class Vale extends Model
{
    use HasFactory, ValesAndArticulos, HasApiTokens;
    protected $table = "vales";
    protected $primaryKey = 'id_vale';
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
}
