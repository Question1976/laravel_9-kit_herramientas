<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\ProductosFotos;

class ApiProductosFotosController extends Controller
{
    /**
     * Display a listing of the resource.
     * LISTAR FOTOS
     * http://herramientas.test/api/v1/productos-fotos
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // Consultar todas las fotos ordenadas por ID descendente 
        // (más nuevos primero)
        $datos = ProductosFotos::orderBy('id', 'desc')->get();

        // Devolver respuesta JSON con:
        // - Los datos de las fotos
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     * SUBIR FOTO
     * http://herramientas.test/api/v1/productos-fotos
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // 1: Validar que se haya enviado un archivo en el campo "foto"
        // Si $_FILES["foto"]["tmp_name"] está vacío, significa que no se subió ninguna imagen
        if(empty($_FILES["foto"]["tmp_name"])) {
            // Preparar respuesta de error en formato JSON
            $array = array
		        	(
		        		'response'=>array
			        	(
			        		'estado' => 'Bad Request',
			        		'mensaje' => 'La foto es obligatoria' 
			        	)
		        	)
		        ;  	
            // Retornar respuesta JSON con código HTTP 400 (Bad Request)
		    return response()->json($array, 400);
        }

        // 2: Validar que el archivo sea JPEG o PNG
        if($_FILES["foto"]["type"] == 'image/jpeg' or $_FILES["foto"]["type"] == 'image/png') {
            
            // 3: Determinar la extensión del archivo según su tipo MIME
            switch($_FILES["foto"]["type"]) {
                case 'image/jpeg':
                    $archivo = time() . ".jpg";
                break;
                case 'image/png':
                    $archivo = time() . ".png";
                break;
            }
            
            // 4: Copiar el archivo temporal subido a la carpeta destino
            // $_FILES["foto"]["tmp_name"] = ruta temporal del archivo subido
            // Se guarda en: D:/www/laravel/herramientas/public/uploads/productos/[nombre_generado]
            copy($_FILES["foto"]["tmp_name"], "D:/www/laravel/herramientas/public/uploads/productos/" . $archivo);

        } else {
            // 5: Si el formato no es válido, retornar error
            $array = array
		        	(
		        		'response' => array
			        	(
			        		'estado' => 'Bad Request',
			        		'mensaje' => 'La foto no tiene un formato válido' 
			        	)
		        	);  

            // Retornar respuesta JSON con código HTTP 400 (Bad Request)	
		    return response()->json($array, 400);
        }

        // 6: Guardar el registro en la base de datos (tabla productos_fotos)
        ProductosFotos::create(
                [ 
                    'nombre' => $archivo,    // Nombre del archivo generado
                    'productos_id' => $request->input('productos_id'),  // ID del producto asociado (viene en el request)
                ]
            );

        // 7: Preparar y retornar respuesta de éxito
        $array = array
                (
                    'estado' => 'ok',
                    'mensaje' => 'Se creó el registro correctamente', 
                ); 

        // Retornar JSON con código HTTP 201 (Created)
        return response()->json( $array, 201);
    }

    /**
     * Display the specified resource.
     * LISTAR/OBTENER FOTO POR ID
     * http://herramientas.test/api/v1/productos-fotos/5
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar la foto específica por su ID
        // Devuelve el más nuevo primero
        $datos = ProductosFotos::where(['productos_id' => $id])->orderBy('id', 'desc')->get();

        // Devolver respuesta JSON con:
        // - Los datos de las fotos
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Update the specified resource in storage.
     * No se actualizan fotos en esta api
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // No se actualizan fotos en esta api
        // Devolvemos mensaje de error
        $array = array
            (
                'response' => array
                (
                    'estado' => 'Página no encontrada',
                    'mensaje' => 'Página no encontrada' 
                )
            );  

        // Retornar respuesta JSON con código HTTP 404 (Not found)	
        return response()->json($array, 404);
    }

    /**
     * Remove the specified resource from storage.
     * ELIMINAR FOTO
     * http://herramientas.test/api/v1/productos-fotos/7
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1. BUSCAR PRODUCTO POR ID 
        $datos = ProductosFotos::where(['id' => $id])->firstOrFail();

        // 2. BORRAR LA FOTO
        unlink('D:/www/laravel/herramientas/public/uploads/productos/' . $datos->nombre);

        // 3. ELIMINAR REGISTRO
        ProductosFotos::where(['id' => $id])->delete();

        // 4: Preparar y retornar respuesta de éxito
        $array = array
                (
                    'estado' => 'ok',
                    'mensaje' => 'Se eliminó el registro correctamente', 
                ); 

        // Retornar JSON con código HTTP 200 (Ok)
        return response()->json( $array, 200);
    }
}
