<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenRecurso extends Model
{
    use HasFactory;
    protected $table = "origen_recursos";
    protected $primaryKey = 'id_origen';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_recurso',
    ];
}
