<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EjemploController extends Controller
{
    /**
     * Display a listing of the resource.
     * LISTAR DATOS
     * http://herramientas.test/api/v1/ejemplo
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "Método GET";
    }

    /**
     * Store a newly created resource in storage.
     * CREAR DATOS
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "Método POST";
    }

    /**
     * Display the specified resource.
     * LISTAR POR ID
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo "Método GET con parámetros | id = " . $id;
    }

    /**
     * Update the specified resource in storage.
     * ACTUALIZAR DATOS
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo "Método PUT | id = " . $id;
    }

    /**
     * Remove the specified resource from storage.
     * ELIMINAR DATOS
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "Método DELETE | id = " . $id;
    }
}
