<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;

class HelperController extends Controller
{
    /**
     * Mostrar vista - Menú formularios
     * http://herramientas.test/helper
     */
    public function helper_inicio() {
        // Usar helper personalizado
        $version = Helpers::getVersion();   

        // Cargar vista
        return view('helper.home', compact('version'));
    }
}
