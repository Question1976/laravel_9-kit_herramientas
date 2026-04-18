<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMetadata;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class ApiAccesoController extends Controller
{    
    /**
     * Store a newly created resource in storage.
     * LOGIN PARA OBTENER JWT
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

        // 3. COMPROBAR SI EXISTE EL CORREO EN LA TABLA 'users'
        // Buscamos en la base de datos un usuario cuyo email coincida con el recibido en la petición
        // Usamos el método where() para filtrar por el campo 'email' 
        // y first() para obtener el primer resultado
        // Si no existe, retornará null
        $users = User::where(['email' => $request->input('correo') ])->first();

        // 4. SI NO ES UN OBJETO, RETORNAR ERROR
        // Verificamos si la consulta anterior retornó un usuario válido (objeto)
        // Si es null o no es un objeto, significa que no se encontró ningún usuario con ese email
        if(!is_object($users)) {
            $array = array
                    (
                        'estado' => 'Bad Request',
                        'mensaje' => 'Las credenciales ingresadas no son válidas', 
                    ); 
            
            // Retornamos error 400 indicando credenciales inválidas
            return response()->json( $array, 400);
        }

        // 5. OBTENER METADATOS DEL USUARIO
        // Buscamos los metadatos adicionales del usuario en la tabla 'user_metadata'
        // Usamos el ID del usuario encontrado en el paso 3 para buscar su registro correspondiente
        // Esto permite tener información extendida del usuario separada de la tabla users 
        $users_metadata = UserMetadata::where(['users_id'=>$users->id ])->first();

        // 6. VALIDAR QUE EXISTEN LOS METADATOS DEL USUARIO
        // Comprobamos si se encontraron los metadatos del usuario
        // Si no existe un registro en user_metadata para este usuario, consideramos las credenciales inválidas
        // Esto añade una capa extra de validación de seguridad
        if(!is_object($users_metadata)) {
            $array = array
                    (
                        'estado' => 'Bad Request',
                        'mensaje' => 'Las credenciales ingresadas no son válidas', 
                    ); 

            // Retornamos error 404 indicando que no se encontró el recurso completo del usuario
            return response()->json( $array, 404);
        }

        // 7. VALIDAR CONTRASEÑA CON AUTH::ATTEMPT
        // Usamos el sistema de autenticación de Laravel para verificar las credenciales
        // Auth::attempt() retorna true si el email y password son correctos, false en caso contrario
        // Esto valida que la contraseña encriptada coincida con la proporcionada
        if(!Auth::attempt(['email' => $request->input('correo'), 'password' => $request->input('password')])) {
            $array = array
                    (
                        'estado' => 'Bad Request',
                        'mensaje' => 'Las credenciales ingresadas no son válidas', 
                    );
                    
            // Retornamos error 400 si la autenticación falla (password incorrecto)
            return response()->json( $array, 400);
        }

        // 8. OBTENER TIMESTAMP ACTUAL
        // Convertimos la fecha y hora actual a un timestamp (segundos desde 1970)
        // Este valor se usará como claim 'iat' (issued at) en el token JWT
        // Indica el momento exacto en que fue emitido el token
        $fecha = strtotime(date('Y-m-d H:i:s'));
        
        // 9. CREAR EL PAYLOAD DEL TOKEN JWT
        // Preparamos los datos que se incluirán dentro del token JWT
        // 'id': El ID del usuario desde sus metadatos (identificador único)
        // 'iat': Timestamp de emisión del token (issued at)
        // Estos claims son el contenido del token que se puede decodificar pero no modificar
        $payload = [
            'id' => $users_metadata->id,
            'iat' => $fecha
        ];

        // 10. GENERAR TOKEN JWT
        // Codificamos el payload creando el token JWT firmado
        // Usamos el algoritmo HS512 (HMAC con SHA-512) para firmar el token
        // env('SECRETO') obtiene la clave secreta desde el archivo .env para firmar/verificar tokens
        // El resultado es un string codificado que representa el token JWT completo
        $jwt = JWT::encode($payload, env('SECRETO'), 'HS512');

        // 11. PREPARAR RESPUESTA DE ÉXITO
        // Creamos el array de respuesta con los datos del login exitoso
        // 'estado': 'ok' indica que la autenticación fue exitosa
        // 'nombre': El nombre del usuario autenticado
        // 'token': El token JWT generado que el cliente usará para autenticar peticiones futuras
        $array = array
                (
                    'estado' => 'ok',
                    'nombre' => $users->name, 
                    'token' => $jwt
                ); 

        // Retornamos JSON con código HTTP 200 (OK) incluyendo el token JWT
        return response()->json( $array, 200);
    }    
}
