@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 text-center mt-3">            
                <p class="display-6">Métodos Helpers de Laravel y Helpers personalizados</p>     
                <p>Métodos que facilitan tareas comunes: manipular arrays, strings, rutas, gestionar vistas... Sirven para simplificar código y evitar la repetición, siendo accesibles desde cualquier parte de la aplicación (controladores y vistas)</p>  

                <hr />
                
                <p>Helper básico 'slug', convierte un string a slug: Don Quijote de la Mancha</p>
                <p class="fw-bold">{{ Str::slug('Don Quijote de la Mancha') }}</p>

                <hr />

                <p>Helper personalizado 'getVersion', muestra versión de la app</p>
                <p class="fw-bold">{{ $version }}</p>

                <hr />

                <!-- Mostrar Helper directamente desde la vista -->
                <p>Helper personalizado 'getName', muestra nombre</p>
                <p class="fw-bold">{{ Helpers::getName('Salvador') }}</p>
            </div>
        </div>
    </div>
@endsection