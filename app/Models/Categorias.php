<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    /**
     * Atributos personalizados
     */
    protected $guarded = [];            // permite asignar MASIVAMENTE todos los campos de la tabla
    public $timestamps = false;         // desactiva los campos 'created_at' y 'updated_at'
    protected $table = 'categorias';    // define explícitamente el nombre de la tabla en la bbdd
}
