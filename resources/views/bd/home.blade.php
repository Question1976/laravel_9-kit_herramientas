@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Base de Datos</p>
                    <p>Operaciones CRUD con base de datos SQL y tablas relacionadas</p>                
                </div>   
            </div>
            <ul>
                <li>
                    <a href="{{ route('bd_categorias') }}" class="fw-bold">Categorías</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('bd_productos') }}" class="fw-bold">Productos</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('bd_productos_paginacion') }}" class="fw-bold">Paginación de Productos</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('bd_buscador') }}" class="fw-bold">Buscador de Productos</a>
                </li>
            </ul>
        </div>
    </div>
@endsection