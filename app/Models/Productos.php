<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categorias;

class Productos extends Model
{
    use HasFactory;

    /**
     * Atributos personalizados
     */
    protected $guarded = [];         // permite asignar MASIVAMENTE todos los campos de la tabla
    public $timestamps = false;      // desactiva los campos 'created_at' y 'updated_at'
    protected $table = 'productos';  // define explícitamente el nombre de la tabla en la bbdd

    /**
     * Añadir 'contrato' para la relación
     * entre tablas 'productos' y 'categorias'
     * a nivel de Eloquent
     */
    public function categorias() {
        return $this->belongsTo(Categorias::class);
    }
}
