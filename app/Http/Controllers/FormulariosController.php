<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ValidaSelect2;

class FormulariosController extends Controller
{
    /**
     * Mostrar vista - Menú formularios
     * http://herramientas.test/formularios
     */
    public function formularios_inicio() {
        return view('formularios.home');
    }

    /**
     * Formulario simple
     * http://herramientas.test/formularios/simple
     */
    public function formularios_simple() {
        // Para 'select' dinámico
        $paises = array(
            array(
                "nombre" => "España", "id" => 1
            ),
            array(
                "nombre" => "Inglaterra", "id" => 2
            ),
            array(
                "nombre" => "Escocia", "id" => 3
            ),
            array(
                "nombre" => "Irlanda", "id" => 4
            ),
            array(
                "nombre" => "Gales", "id" => 5
            )
        );

        // Para 'checkbox'
        $intereses=array(
            array(
                "nombre" => "Deportes", "id" => 1
            ),
            array(
                "nombre" => "Música", "id" => 2
            ),
            array(
                "nombre" => "Religión", "id" => 3
            ),
            array(
                "nombre" => "Comida", "id" => 4
            ),
            array(
                "nombre" => "Viajes", "id" => 5
            )
        );

        // Pasar los arrays/datos a la vista
        return view('formularios.simple', compact('paises', 'intereses'));
    }

    public function formularios_simple_post(Request $request) {
        // Validaciones    
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'correo' => 'required|email:rfc,dns',
                'password' => 'required|min:6',
                'descripcion' => 'required', 
                'pais' => [new ValidaSelect2]               
            ],
            [
                'nombre.required' => 'El campo nombre está vacío', 
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres', 
                'correo.required' => 'El campo email está vacío',
                'correo.email' => 'El email ingresado no es válido',
                'descripcion.required' => 'El campo descripción está vacío',
                'password.required' => 'El campo contraseña está vacío',
                'password.min' => 'El campo contraseña debe tener al menos 6 caracteres',
            ]
        );
        
        // Para 'checkbox'
        $intereses=array(
            array(
                "nombre" => "Deportes", "id" => 1
            ),
            array(
                "nombre" => "Música", "id" => 2
            ),
            array(
                "nombre" => "Religión", "id" => 3
            ),
            array(
                "nombre" => "Comida", "id" => 4
            ),
            array(
                "nombre" => "Viajes", "id" => 5
            )
        );

        // Redireccionar
        return view('formularios.enviado');  
    }

    /**
     * Formulario mensajes flash
     * http://herramientas.test/formularios/flash
     */
    public function formularios_flash() {
        // Cargar la vista
        return view('formularios.flash');
    }

    public function formularios_flash2(Request $request) {
        // Crear mensajes flash
        $request->session()->flash('css', 'success');      // nombre de la sesión, clase css
        $request->session()->flash('mensaje', 'Mensaje desde Flash');

        // Redireccionar
        return redirect()->route('formularios_flash3');     // envia el mensaje a formularios_flash3
    }

    public function formularios_flash3() {
        // Cargar la vista
        return view('formularios.flash3');
    }

    /**
     * Formulario upload de archivos
     * http://herramientas.test/formularios/upload
     */
    public function formularios_upload() {
        // Cargar la vista
        return view('formularios.upload');
    }

    public function formularios_upload_post(Request $request) {
        // Validaciones
        $request->validate(
            [
                'foto' => 'required|mimes:jpg,png|max:2040' 
            ],
            [
                'foto.required' => 'El campo foto está vacío',
                'foto.mimes' => 'El campo foto debe set JPG|PNG'
            ]
        );

        // Obtener extensión del archivo
        switch($_FILES['foto']['type']) {
            case 'image/png':
                $archivo = time() . ".png";
            break;
            case 'image/jpeg':
                $archivo = time() . ".jpg";
            break;
        }

        // Upload del archivo
        copy($_FILES['foto']['tmp_name'], 'uploads/udemy/' . $archivo);

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se subió el archivo correctamente");

        // Redireccionar
        return redirect()->route('formularios_upload');
    }
}
