@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Nueva Categoría</p>                                
                </div>   

                <!-- Mensajes flash -->
                <x-flash />

                <form action="{{ route('bd_categorias_add_post') }}" method="POST" class="w-auto">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control shadow-sm" value="{{ old('nombre') }}" placeholder="Introduce nombre de Categoría" />
                    </div>

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <div class="mt-3">
                        <input type="submit" value="Enviar" class="btn btn-success" />
                        <a href="{{ route('bd_categorias')}}" class="btn btn-danger ms-2">Volver</a>
                    </div>
                </form>
            </div>            
        </div>
    </div>
@endsection