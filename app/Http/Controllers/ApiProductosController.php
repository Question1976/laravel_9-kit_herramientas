<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\ProductosFotos;
use Illuminate\Support\Str;


class ApiProductosController extends Controller
{
    /**
     * Autenticación
     */
    public function __construct()
    {
        //$this->middleware('auth.basic');            // Autenticación básica
        $this->middleware('verificacion');        // Autenticación personalizada
    }

    /**
     * Display a listing of the resource.
     * LISTAR PRODUCTOS
     * http://herramientas.test/api/v1/productos
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Consultar todas los productos ordenadas por ID descendente 
        // (más nuevos primero)
        $datos = Productos::orderBy('id', 'desc')->get();

        // Devolver respuesta JSON con:
        // - Los datos de los productos
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     * CREAR PRODUCTOS
     * http://herramientas.test/api/v1/productos
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
        Productos::create(
            [
                'nombre' => $request->input('nombre'),                        
                'slug' => Str::slug($request->input('nombre', '-')),
                'descripcion' => $request->input('descripcion'),
                'precio' => $request->input('precio'),
                'categorias_id' => $request->input('categorias_id'),
                'fecha' => date('Y-m-d')      
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
     * LISTAR/OBTENER PRODUCTO POR ID
     * http://herramientas.test/api/v1/productos/11
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buscar el producto específico por su ID
        // firstOrFail(): devuelve el registro o lanza error 404 si no existe
        $datos = Productos::where(['id' => $id])->firstOrFail();

        // Devolver respuesta JSON con:
        // - Los datos de los productos
        // - Código de estado HTTP 200 (OK)
        return response()->json($datos, 200);
    }

    /**
     * Update the specified resource in storage.
     * ACTUALIZAR PRODUCTO
     * http://herramientas.test/api/v1/productos/15
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

        // 4. BUSCAR PRODUCTO POR ID 
        $datos = Productos::where(['id' => $id])->firstOrFail();

        // 5. ACTUALIZAR LOS CAMPOS
        $datos->nombre = $request->input('nombre');
        $datos->slug = Str::slug($request->input('nombre'));
        $datos->descripcion = $request->input('descripcion');
        $datos->precio = $request->input('precio');
        $datos->categorias_id = $request->input('categorias_id');

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
     * ELIMINAR PRODUCTO
     * http://herramientas.test/api/v1/productos/15
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1. BUSCAR PRODUCTO POR ID 
        $datos = Productos::where(['id' => $id])->firstOrFail();

        // 2. VERIFICAR SI EL PRODUCTO TIENE FOTOS ASOCIADAS
        // Regla de negocio: NO eliminar producto si tiene fotos (evitar huérfanos)
         if (ProductosFotos::where(['productos_id' => $id])->count() == 0) {

            // NO tiene fotos, Proceder a eliminar
            Productos::where(['id' => $id])->delete();

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
            // SÍ tiene fotos, NO eliminar (integridad de datos)
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
