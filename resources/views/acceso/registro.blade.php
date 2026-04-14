@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Registro de usuarios</p>
                </div>  
                
                <!-- Mostrar mensajes de error para las validaciones | componente 'flash' -->
                <x-flash />
                
                <form action="{{ route('acceso_registro_post') }}" method="POST" class="mb-5">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control shadow-sm" value="{{ old('nombre') }}" placeholder="Introduce nombre" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="correo">Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control shadow-sm" value="{{ old('correo') }}" placeholder="Introduce correo" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control shadow-sm" placeholder="Introduce contraseña" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="password2">Repetir contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control shadow-sm" placeholder="Confirma contraseña" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control shadow-sm" value="{{ old('telefono') }}" placeholder="Introduce teléfono" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control shadow-sm" value="{{ old('direccion') }}" placeholder="Introduce dirección" />
                    </div>

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <input type="submit" value="Enviar" class="btn btn-success mt-3"> 
                </form>
            </div>
        </div>
    </div>
@endsection