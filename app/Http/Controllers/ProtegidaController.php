<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProtegidaController extends Controller
{
    /**
     * Middleware personalizado
     * Proteger todas las rutas de este controlador
     */
    public function __construct()
    {
        $this->middleware('acceso');
    }

    /**
     * Ruta protegida
     * Para usuarios Administradores
     * http://herramientas.test/protegida
     */
    public function protegida_inicio() {
        // Comprobar tipo usuario
        // 1 admin | 2 user
        if (session('perfil_id') != 1) {
            // No puede entrar, no es admin
            return redirect()->route('protegida_sin_acceso');
        }
        return view('protegida.home');      // Mostrar vista
    }

    /**
     * Ruta protegida 2
     * http://herramientas.test/protegida/otra
     */
    public function protegida_otra() {
        return view('protegida.otra');      // Mostrar vista
    }

    /**
     * Ruta protegida sin acceso
     * http://herramientas.test/protegida/sin-acceso
     */
    public function protegida_sin_acceso() {
        return view('protegida.sin_acceso');      // Mostrar vista
    }
}
