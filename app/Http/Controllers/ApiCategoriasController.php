<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Productos;
use Illuminate\Support\Str;


class ApiCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     * LISTAR CATEGORÍAS
     * http://herramientas.test/api/v1/categorias
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Consultar todas las categorías ordenadas por ID descendente 
        // (más nuevas primero)
        $datos = Categorias::orderBy('id', 'desc')->get();

        // Devolver respuesta JSON con:
        // - Los datos de las categorías
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     * CREAR DATOS
     * http://herramientas.test/api/v1/categorias
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. RECIBIR EL JSON ENVIADO EN EL BODY DE LA PETICIÓN
        // file_get_contents('php://input') lee el cuerpo crudo de la petición HTTP
        // json_decode(..., true) convierte el JSON a array asociativo de PHP
        $json = json_decode(file_get_contents('php://input'), true);

        // 2. VALIDAR QUE LOS DATOS SON VÁLIDOS
        // Si no es un array, significa que no llegó JSON o llegó malformado
        if(!is_array($json)) {
       		$array = array
		        	(
		        		'response' => array
			        	(
			        		'estado' => 'Bad Request',
			        		'mensaje' => 'La peticion HTTP no trae datos para procesar' 
			        	)
		        	)
		        ;  	

            // Retornar JSON con código HTTP 400 (Bad Request)
		    return response()->json($array, 400);
        }

        // 3. CREAR EL REGISTRO EN LA BBDD
        Categorias::create(
            [
                'nombre' => $json['nombre'],                        // Nombre recibido del json
                'slug' => Str::slug($json['nombre'], '-')           // Slug generado automáticamente
            ]
        );

       // 4. PREPARAR Y RETORNAR RESPUESTA DE ÉXITO
       $array = array 
            (
                'response' => array
                (
                    'estado' => 'Ok',
                    'mensaje' => 'Se creó el registro correctamente' 
                )
            );
        
        // Retornar JSON con código HTTP 201 (Created)
        return response()->json($array, 201);
    }

    /**
     * Display the specified resource.
     * LISTAR/OBTENER CATEGORÍA POR ID
     * http://herramientas.test/api/v1/categorias/3
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar la categoría específica por su ID
        // firstOrFail(): devuelve el registro o lanza error 404 si no existe
        $datos = Categorias::where(['id' => $id])->firstOrFail();

        // Devolver respuesta JSON con:
        // - Los datos de las categorías
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Update the specified resource in storage.
     * ACTUALIZAR DATOS
     * http://herramientas.test/api/v1/categorias/8
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 1. RECIBIR EL JSON ENVIADO EN EL BODY DE LA PETICIÓN
        // file_get_contents('php://input') lee el cuerpo crudo de la petición HTTP
        // json_decode(..., true) convierte el JSON a array asociativo de PHP
        $json = json_decode(file_get_contents('php://input'), true);

        // 2. VALIDAR QUE LOS DATOS SON VÁLIDOS
        // Si no es un array, significa que no llegó JSON o llegó malformado
        if(!is_array($json)) {
       		$array = array
		        	(
		        		'response' => array
			        	(
			        		'estado' => 'Bad Request',
			        		'mensaje' => 'La peticion HTTP no trae datos para procesar' 
			        	)
		        	)
		        ;  	

            // Retornar JSON con código HTTP 400 (Bad Request)
		    return response()->json($array, 400);
        }

        // 4. BUSCAR LA CATEGORÍA POR ID 
        $datos = Categorias::where(['id' => $id])->firstOrFail();

        // 5. ACTUALIZAR LOS CAMPOS
        $datos->nombre = $request->input('nombre');
        $datos->slug = Str::slug($request->input('nombre'));

        // 6. GUARDAR LOS CAMBIOS
        $datos->save();

        // PREPARAR Y RETORNAR RESPUESTA DE ÉXITO
        $array = array 
            (
                'response' => array
                (
                    'estado' => 'Ok',
                    'mensaje' => 'Se modificó el registro correctamente' 
                )
            );
       
        // Retornar JSON con código HTTP 200 (Ok)
        return response()->json($array, 200);
    }

    /**
     * Remove the specified resource from storage.
     * ELIMINAR DATOS
     * http://herramientas.test/api/v1/
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1. BUSCAR LA CATEGORÍA POR ID 
        $datos = Categorias::where(['id' => $id])->firstOrFail();

        // 2. VERIFICAR SI LA CATEGORÍA TIENE PRODUCTOS ASOCIADOS
        // Regla de negocio: NO eliminar categoría si tiene productos (evitar huérfanos)
        if (Productos::where(['categorias_id' => $id])->count() == 0) {

            // NO tiene productos, Proceder a eliminar
            Categorias::where(['id' => $id])->delete();

            // Respuesta de éxito
            $array = array
                    (
                        'response' => array
                        (
                            'estado' => 'Ok',
                            'mensaje' => 'Se eliminó el registro correctamente' 
                        )
                    )
                ;  	

            // Retornar JSON con código HTTP 200 (Ok)
            return response()->json($array, 200);
        } else {
            // SÍ tiene productos, NO eliminar (integridad de datos)
            if(!is_array($json)) {
                $array = array
                        (
                            'response' => array
                            (
                                'estado' => 'Bad Request',
                                'mensaje' => 'No es posible eliminar el registro' 
                            )
                        )
                    ;  	

                // Retornar JSON con código HTTP 400 (Bad Request)
                return response()->json($array, 400);
            }
        }         
    }
}
