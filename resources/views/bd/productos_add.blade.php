@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Nuevo Producto</p>                                
                </div>   

                <!-- Mensajes flash -->
                <x-flash />

                <form action="{{ route('bd_productos_add_post') }}" method="POST" class="w-auto">
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select class="form-control shadow-sm" name="categorias_id" id="categorias_id">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach  
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control shadow-sm" value="{{ old('nombre') }}" placeholder="Introduce nombre del producto" />
                    </div>

                    <div class="form-group mt-2">
                        <label for="precio">Precio</label>
                        <input type="text" name="precio" id="precio" class="form-control shadow-sm" value="{{ old('precio') }}" onkeypress="return soloNumeros(event)" placeholder="Introduce precio del producto" />
                    </div>

                    <div class="form-group mt-2">
                        <label for="stock">Stock</label>
                        <select class="form-control shadow-sm" name="stock" id="stock">
                            @for ($i = 1; $i <= 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control shadow-sm">{{ old('descripcion') }}</textarea>
                    </div>

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <div class="mt-3 mb-5">
                        <input type="submit" value="Enviar" class="btn btn-success" />
                        <a href="{{ route('bd_productos')}}" class="btn btn-danger ms-2">Volver</a>
                    </div>
                </form>
            </div>            
        </div>
    </div>
@endsection