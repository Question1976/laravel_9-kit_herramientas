@extends('layouts.frontend')

@section('content')
<div class="d-flex align-items-center justify-content-center">
    <div class="row">
        <div class="col-12 mt-3">
            <div class="text-center">
                <p class="display-6">Integración de API externa privada</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Estado de la conexión -->
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Estado:</strong> {{ $status }} 
            @if($status == 200)
                <span class="badge bg-success ms-2">Conectado</span>
            @else
                <span class="badge bg-danger ms-2">Error</span>
            @endif
        </div>

        <!-- Tabla de productos -->
        @if(isset($datos->datos) && count($datos->datos) > 0)
        <div class="table-responsive mt-4 mb-5">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Categoría</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datos->datos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td><strong>{{ $producto->nombre }}</strong></td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>${{ number_format($producto->precio, 0, '', '.') }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>{{ $producto->categoria }}</td>
                        <td>{{ $producto->fecha }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-warning text-center">
            No hay productos disponibles
        </div>
        @endif
    </div>
</div>
@endsection