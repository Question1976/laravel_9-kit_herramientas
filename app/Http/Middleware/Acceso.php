<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Acceso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // ¿Usuario logueado?
        if (Auth::check() == false) {
            // Usuario NO logueado
            
            // Mensaje flash
            $request->session()->flash('css', 'warning');
            $request->session()->flash('mensaje', 'Debes estar logueado/a para acceder a este contenido');

            // Redireccionar
            return redirect('/acceso/login');
        }
        return $next($request);
    }
}
