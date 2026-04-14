@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Login de usuarios</p>
                </div>  
                
                <!-- Mostrar mensajes de error para las validaciones | componente 'flash' -->
                <x-flash />
                
                <form action="{{ route('acceso_login_post') }}" method="POST" class="mb-5">
                    <div class="form-group mt-3">
                        <label for="correo">Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control shadow-sm" value="{{ old('correo') }}" placeholder="Introduce correo" />
                    </div>

                    <div class="form-group mt-3">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control shadow-sm" placeholder="Introduce contraseña" />
                    </div>                

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <input type="submit" value="Enviar" class="btn btn-success mt-3"> 
                </form>
            </div>
        </div>
    </div>
@endsection