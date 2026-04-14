<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\ProductosFotos;
use Illuminate\Support\Str;


class BdController extends Controller
{
    /**
     * Mostrar vista - Menú ORM
     * http://herramientas.test/bd
     */
    public function bd_inicio() {
        return view('bd.home');             // mostrar vista
    }

    // ==================
    // === CATEGORÍAS ===
    // ==================

    /**
     * Listar Categorías
     * http://herramientas.test/bd/categorias
     */
    public function bd_categorias() {        
        $datos = Categorias::orderBy('id', 'desc')->get();  // traer todos los registros      
        return view('bd.categorias', compact('datos'));     // pasar a la vista
    }

    /**
     * Crear Categorías
     * http://herramientas.test/bd/categorias/add
     */
    public function bd_categorias_add() {
        return view('bd.categorias_add');       // mostrar vista
    }

    public function bd_categorias_add_post(Request $request) {
        // Validaciones    
        $request->validate(
            [
                'nombre' => 'required|min:6'
            ],
            [
                'nombre.required' => 'El campo nombre está vacío',
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres'
            ]
        );

        // Crear registro / Ejecutar consulta
        Categorias::create(
            [
                'nombre' => $request->input('nombre'),
                'slug' => Str::slug($request->input('nombre'), '-') 
            ]
        );

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', 'Registro creado correctamente');

        // Redireccionar
        return redirect()->route('bd_categorias_add');
    }

    /**
     * Editar Categorías
     * http://herramientas.test/bd/categorias/edit/1
     */
    public function bd_categorias_edit($id) {
        $categoria = Categorias::where(['id' => $id])->firstOrFail(); // obtener id por url
        return view('bd.categorias_edit', compact('categoria'));// mostrar vista y pasarle valor
    }

    public function bd_categorias_edit_post(Request $request, $id) {
        // Validaciones    
        $request->validate(
            [
                'nombre' => 'required|min:6'
            ],
            [
                'nombre.required' => 'El campo nombre está vacío',
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres'
            ]
        );

        // Obtener id por url (1 registro)
        $categoria = Categorias::where(['id' => $id])->firstOrFail();

        // Campos a modificar (formulario)
        $categoria->nombre = $request->input('nombre');
        $categoria->slug = Str::slug($request->input('nombre'), '-');

        // Editar registro / Ejecutar consulta
        $categoria->save();

        // Mensaje flash
        $request->session()->flash('css', 'warning');
        $request->session()->flash('mensaje', 'Registro editado correctamente');

        // Redireccionar
        return redirect()->route('bd_categorias_edit', ['id' => $id]);
    }

    /**
     * Eliminar Categorías
     * http://herramientas.test/bd/categorias/delete
     */
    public function bd_categorias_delete(Request $request, $id) {
        // Eliminar una categoría solo si no tiene 
        // productos asociados (para evitar datos huérfanos)

        // Comprobar si existe el producto
        // ¿Hay productos en esta categoría?
        if (Productos::where(['categorias_id' => $id])->count() == 0) {
            // NO hay productos, puedo borrar la categoría

            // Eliminar registro / Ejecutar consulta
            Categorias::where(['id' => $id])->delete();

            // Mensaje flash
            $request->session()->flash('css', 'success');
            $request->session()->flash('mensaje', 'Registro eliminado correctamente');

            // Redireccionar
            return redirect()->route('bd_categorias');
        } else {
            // SÍ hay productos, NO borro la categoría (por seguridad)

            // Mensaje flash
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', 'No es posible eliminar el registro');

            // Redireccionar
            return redirect()->route('bd_categorias');
        }     
    }

    // =================
    // === PRODUCTOS ===
    // =================

    /**
     * Listar Productos
     * http://herramientas.test/bd/productos
     */
    public function bd_productos() {        
        $datos = Productos::orderBy('id', 'desc')->get();  // traer todos los registros      
        return view('bd.productos', compact('datos'));     // pasar a la vista
    }

    /**
     * Crear Productos
     * http://herramientas.test/bd/productos/add
     */
    public function bd_productos_add() {
        $categorias = Categorias::get();                            // traer todos los registros
        return view('bd.productos_add', compact('categorias'));     // pasar a la vista
    }

    public function bd_productos_add_post(Request $request) {
        // Validaciones
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'precio' => 'required|numeric',
                'descripcion' => 'required'  
            ],
            [
                'nombre.required' => 'El campo nombre está vacío',
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres',
                'precio.required' => 'El campo precio está vacío',
                'precio.numeric' => 'El precio ingresado no es válido',
                'descripcion.required' => 'El campo descripción está vacío', 
            ]
        );

        // Crear registro / Ejecutar consulta
        Productos::create(
            [
                'nombre' => $request->input('nombre'),
                'slug' => Str::slug($request->input('nombre'), '-'),
                'precio' => $request->input('precio'),
                'stock' => $request->input('stock'),
                'descripcion' => $request->input('descripcion'),
                'categorias_id' => $request->input('categorias_id'),
                'fecha' => date('Y-m-d')
            ]
        );

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', 'Registro creado correctamente');

        // Redireccionar
        return redirect()->route('bd_productos_add');
    }

    /**
     * Editar Productos
     * http://herramientas.test/bd/productos/edit/1
     */
    public function bd_productos_edit($id) {
        $producto = Productos::where(['id' => $id])->firstOrFail();  // obtener id por url
        $categorias = Categorias::get();        // obtener categoria asociada al producto
        // mostrar vista y pasarle valores
        return view('bd.productos_edit', compact('producto', 'categorias'));  
    }

    public function bd_productos_edit_post(Request $request, $id) {
        // Validaciones
        $request->validate(
            [
                'nombre' => 'required|min:6',
                'precio' => 'required|numeric',
                'descripcion' => 'required'  
            ],
            [
                'nombre.required' => 'El campo nombre está vacío',
                'nombre.min' => 'El campo nombre debe tener al menos 6 caracteres',
                'precio.required' => 'El campo precio está vacío',
                'precio.numeric' => 'El precio ingresado no es válido',
                'descripcion.required' => 'El campo descripción está vacío', 
            ]
        );

        // Obtener id por url (1 registro)
        $producto = Productos::where(['id' => $id])->firstOrFail();

        // Campos a modificar (formulario)
        $producto->nombre = $request->input('nombre');
        $producto->slug = Str::slug($request->input('nombre'), '-');
        $producto->categorias_id = $request->input('categorias_id');
        $producto->precio = $request->input('precio');
        $producto->stock = $request->input('stock');
        $producto->descripcion = $request->input('descripcion');
        

        // Editar registro / Ejecutar consulta
        $producto->save();

        // Mensaje flash
        $request->session()->flash('css', 'warning');
        $request->session()->flash('mensaje', 'Registro editado correctamente');

        // Redireccionar
        return redirect()->route('bd_productos_edit', ['id' => $id]);
    }

    /**
     * Eliminar Productos
     * http://herramientas.test/bd/productos/delete/1
     */
    public function bd_productos_delete(Request $request, $id) {
        // Obtener id por url (1 registro)
        $producto = Productos::where(['id' => $id])->firstOrFail();
        
        // ¿Este producto tiene fotos en la tabla 'productos_fotos'?
        if (ProductosFotos::where(['productos_id' => $id])->count() == 0) {

            // NO tiene fotos, puedo borrar el producto con seguridad
            Productos::where(['id' => $id])->delete();

            // Mensaje flash
            $request->session()->flash('css', 'success');
            $request->session()->flash('mensaje', 'Registro eliminado correctamente');

            // Redireccionar
            return redirect()->route('bd_productos');
        } else {
            // SÍ tiene fotos, NO borro el producto (integridad de datos)

            // Mensaje flash
            $request->session()->flash('css', 'danger');
            $request->session()->flash('mensaje', 'No es posible eliminar el registro');

            // Redireccionar
            return redirect()->route('bd_productos');
        }        
    }

    /**
     * Listar Productos por Categorías
     * http://herramientas.test/bd/productos/categorias/1
     */
    public function bd_productos_categorias($id) {      
        // Busca la categoría 
        $categoria = Categorias::where(['id' => $id])->firstOrFail(); 

        // Obtiene productos de esa categoría, ordenados del más nuevo al más antiguo
        $datos = Productos::where(['categorias_id' => $id])->orderBy('id', 'desc')->get(); 

        // Envía los datos a la vista
        return view('bd.productos_categorias', compact('datos', 'categoria')); 
    }

    /**
     * Listar Fotos de Productos
     * http://herramientas.test/bd/productos/fotos/1
     */
    public function bd_productos_fotos($id) {
        // Obtener id por url (1 registro)
        $producto = Productos::where(['id' => $id])->firstOrFail();

        // Obtener todas las fotos que corresponden al producto
        $fotos = ProductosFotos::where(['productos_id' => $id])->orderBy('id', 'desc')->get();

        // Envía los datos a la vista
        return view('bd.productos_fotos', compact('fotos', 'producto')); 
    }

    public function bd_productos_fotos_post(Request $request, $id) {
        // Obtener id por url (1 registro)
        $producto = Productos::where(['id' => $id])->firstOrFail();

        // Validaciones
        $request->validate(
            [
                'foto' => 'required|mimes:jpg,png|max:2048' 
            ],
            [
                'foto.required' => 'El campo foto está vacío',
                'foto.mimes' => 'El campo foto debe tener el formato JPG|PNG'
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
        copy($_FILES['foto']['tmp_name'], 'uploads/productos/' . $archivo);

        // Crear registro
        ProductosFotos::create(
            [
                'productos_id' => $id,
                'nombre' => $archivo
            ]
        );

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se subió el archivo correctamente");

        // Redireccionar
        return redirect()->route('bd_productos_fotos', ['id' => $id]);
    }

    /**
     * Eliminar Fotos de Productos
     * http://herramientas.test/bd/productos/fotos/delete/1/1
     */
    public function bd_productos_fotos_delete(Request $request, $producto_id, $foto_id) {
        // Obtener los id por url (1 registro)
        $producto = Productos::where(['id' => $producto_id])->firstOrFail(); // id del producto
        $foto = ProductosFotos::where(['id' => $foto_id])->firstOrFail();    // id de foto 
        
        // Borrar la foto
        unlink('D:/www/laravel/herramientas/public/uploads/productos/' . $foto->nombre);

        // Eliminar registro
        ProductosFotos::where(['id' => $foto_id])->delete();

        // Mensaje flash
        $request->session()->flash('css', 'success');
        $request->session()->flash('mensaje', "Se eliminó el registro correctamente");

        // Redireccionar
        return redirect()->route('bd_productos_fotos', ['id' => $producto_id]);
    }

    /**
     * Paginación de productos
     * http://herramientas.test/bd/productos/paginacion
     */
    public function bd_productos_paginacion() {
        // Traer productos ordenados del más nuevo al más antiguo
        // Divide los resultados en páginas de 2 elementos
        $datos = Productos::orderBy('id', 'desc')->paginate(env('PAGINACION'));

        // Mostrar vista y pasarle datos
        return view('bd.paginacion', compact('datos'));
    }

    /**
     * Buscador interno de Productos
     * http://herramientas.test/bd/productos/buscador
     */
    public function bd_buscador() {  
        // ¿El usuario escribió algo en el buscador? 
        // (¿existe el parámetro 'b' en la URL?)
        if (isset($_GET['b'])) {
            // Guardamos en $b lo que el usuario escribió (ej: "camisa")
            $b = $_GET['b'];

            // Buscamos productos cuyo nombre CONTENGA el texto buscado
            // LIKE '%camisa%' → encuentra "Camisa roja", "Mi camisa", etc.
            // orderBy('id', 'desc') → muestra primero los más recientes
            // get() → ejecuta la consulta y devuelve los resultados
            $datos = Productos::where('nombre', 'like', '%' . $_GET['b'] . '%')->orderBy('id', 'desc')->get();
        } else {
            // Si no hay búsqueda, inicializamos $b vacío (para que el input no de error)
            $b = '';

            // Sin búsqueda: traemos TODOS los productos, 
            // ordenados del más nuevo al más antiguo
            $datos = Productos::orderBy('id', 'desc')->get();
        }       
            
        // Mostramos la vista 'bd.buscador' y le pasamos:
        // $datos → los productos a mostrar en la tabla
        // $b     → el texto buscado (para que permanezca en el input después de buscar)
        return view('bd.buscador', compact('datos', 'b'));           
    }
}
