<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EjemploMailable;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    /**
     * Mostrar vista - Envio Email
     * http://herramientas.test/email
     */
    public function email_inicio() {
        return view('email.home');
    }

    public function email_enviar(Request $request) {
        $html = "<h2>Este es el cuerpo del correo</h2><hr/>";     // cuerpo del correo
        $correo = new EjemploMailable($html);
        Mail::to("correo@correo.com")->send($correo);

        // Crear mensajes flash
        $request->session()->flash('css', 'success');      // nombre de la sesión, clase css
        $request->session()->flash('mensaje', 'Se envió el email correctamente');

        // Redireccionar
        return redirect()->route('email_inicio');     
    }
}
