<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Verificacion
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
        // 1. RECIBIR header/encabezado
        $headers = explode(' ', $request->header('Authorization'));

        // 2. NO RECIBE header
        if (!isset($headers[1])) {
            $array = array
                (
                    'response' => array
                    (
                        'estado' => 'Unauthorized',
                        'mensaje' => 'Acceso no autorizado'
                    )
                )
            ;

            // Retornamos JSON con código HTTP 401 (No autorizado)  
            return response()->json($array, 401);
        }

        // 3. DECODIFICAR token
        $decoded = JWT::decode($headers[1], new Key(env('SECRETO'), 'HS512'));

        // 4. VALIDAR LA FECHA ACTUAL
        $fecha = strtotime(date('Y-m-d H:i:s'));

        // 5. COMPROBAR SI EL TOKEN NO ESTÁ AUTORIZADO
        if ($decoded->iat > $fecha) {
           $array = array
                (
                    'response' => array
                    (
                        'estado' => 'Unauthorized',
                        'mensaje' => 'Acceso no autorizado'
                    )
                )
            ;

            // Retornamos JSON con código HTTP 401 (No autorizado)  
            return response()->json($array, 401);
        }

        return $next($request);
    }
}
