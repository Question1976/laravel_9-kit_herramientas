<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Perfil;


class UserMetadata extends Model
{
    use HasFactory;

    /**
     * Atributos personalizados
     */
    protected $guarded = [];         // permite asignar MASIVAMENTE todos los campos de la tabla
    public $timestamps = false;      // desactiva los campos 'created_at' y 'updated_at'
    protected $table = 'user_metadata';// define explícitamente el nombre de la tabla en la bbdd

    /**
     * Añadir 'contrato' para la relación
     * con las tablas 'users' y 'perfil'
     * a nivel de Eloquent. LLaves foráneas FK.
     */
    public function users() {
        return $this->belongsTo(User::class);
    }

    public function perfil() {
        return $this->belongsTo(Perfil::class);
    }
}
