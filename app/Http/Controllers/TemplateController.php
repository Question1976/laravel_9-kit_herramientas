<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Mostrar vista | Inicio
     * http://herramientas.test/
     */
    public function template_inicio() {
        return view('template.home');
    }

    /**
     * @stack y @push
     * Cargar librería fancybox 
     * sólo en esta vista 'stack'
     * http://herramientas.test/template/stack
     */
    public function template_stack() {
        return view('template.stack');
    }
}
