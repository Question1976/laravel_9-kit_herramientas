<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AccesoController extends Controller
{
    /**
     * Login
     * http://herramientas.test/acceso/login
     */
    public function acceso_login() {
        return view('acceso.login');     // Mostrar vista
    }

    public function acceso_login_post(Request $request) {
        // Validaciones
        $request->validate(
            [
                'correo' => 'required|email:rfc,dns',
                'password' => 'required|min:6' 
            ],
            [
                'correo.required' => 'El campo e-mail está vacío',
                'correo.email' => 'El e-mail ingresado no es válido',
                'password.required' => 'El campo password está vacío',
                'password.min' => 'El campo password debe tener al menos 6 caracteres'
            ]
        );

        // Autenticación 
        if (Auth::attempt(['email' => $request->input('correo') , 'password' => $request->input('password') ])) {
            // --- Login OK ---       
            // Obtener metadata adicional del usuario autenticado
            $usuario = UserMetadata::where(['users_id' => Auth::id()])->first();

            // Guardar datos en sesión para usarlos en toda la aplicación
            session(['users_metadata_id' => $usuario->id]);
            session(['perfil_id' => $usuario->perfil_id]);      // 1 admin, 2 user
            session(['perfil' => $usuario->perfil->nombre]);    // mostrar nombre usuario 
            
            // Redirigir al usuario (a la página que intentaba visitar o a '/')
            return redirect()->intended('/');
        } else {
            // --- Login Error ---        
            // Mostrar mensaje de error temporal (flash)
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', "Las credenciales indicadas no son válidas");

            // Volver al formulario de login
            return redirect()->route('acceso_login');
        }
    }

    /**
     * Registro
     * http://herramientas.test/acceso/registro
     */
    public function acceso_registro() {
        return view('acceso.registro');     // Mostrar vista
    }

    public function acceso_registro_post(Request $request) {
        // Validaciones
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'correo' => 'required|email:rfc,dns|unique:users,email',
                'telefono' => 'required',
                'direccion' => 'required',
                'password' => 'required|min:6|confirmed' 
            ],
            [
                'nombre.required' => 'El campo nombre está vacío',
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres',
                'correo.required' => 'El campo e-mail está vacío',
                'correo.email' => 'El e-mail ingresado no es válido',
                'correo.unique' => 'El e-mail ingresado ya está siendo usado',
                'telefono.required' => 'El campo teléfono está vacío',
                'direccion.required' => 'El campo dirección está vacío',
                'password.required' => 'El campo password está vacío',
                'password.min' => 'El campo password debe tener al menos 6 caracteres',
                'password.required' => 'El campo password está vacío',
                'password.min' => 'El campo password debe tener al menos 6 caracteres',
                'password.confirmed' => 'Las contraseñas ingresadas no coiciden',
            ]
        );

        // Crear registro / Ejecutar consulta
        // (en cascada | de las 2 tablas)
        $user = User::create(
            [
                'name' => $request->input('nombre'),
                'email' => $request->input('correo'),
                'password' => Hash::make($request->input('password')),                
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        UserMetadata::create(
            [
                'users_id' => $user->id,
                'perfil_id' => 2,
                'telefono' => $request->input('telefono'),
                'direccion' => $request->input('direccion')
            ]
        );

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', 'Registro creado correctamente');

        // Redireccionar
        return redirect()->route('acceso_registro');
    }

    /**
     * Cerrar Sesión
     * http://herramientas.test/acceso/salir
     */
    public function acceso_salir(Request $request) {        
        // Cerrar sesión
        Auth::logout();   
        
        // Destruir datos de sesión
        $request->session()->forget('users_metadata_id');
        $request->session()->forget('perfil_id');
        $request->session()->forget('perfil');

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', 'Cerraste la sesión correctamente');

        // Redireccionar
        return redirect()->route('acceso_login');
    }
}
