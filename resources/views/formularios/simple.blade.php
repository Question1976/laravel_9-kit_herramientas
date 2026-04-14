@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Formulario simple</p> 
                    <p>Validación, campos dinámicos y mensajes flash</p>
                </div>  
                
                <!-- Mostrar mensajes de error para las validaciones | componente 'flash' -->
                <x-flash />
                
                <form action="{{ route('formularios_simple_post') }}" method="POST" name="form" class="mb-5">
                    <div class="form-group">
                        <label for="pais">País</label>
                        <select name="pais" id="pais" class="form-control shadow-sm">
                            <option value="0">Seleccione...</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais['id'] }}">{{ $pais['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- old | no borrar valores de los campos (en validaciones) -->
                    <div class="form-group mt-2">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control shadow-sm" placeholder="Introduce tu nombre" value="{{ old('nombre') }}" />
                    </div>

                    <div class="form-group mt-2">
                        <label for="correo">E-Mail</label>
                        <input type="email" name="correo" id="correo" class="form-control shadow-sm" placeholder="Introduce tu email" value="{{ old('correo') }}" />
                    </div>

                    <div class="form-group mt-2">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control shadow-sm" placeholder="Introduce tu contraseña" />
                    </div>

                    <div class="form-group mt-2">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control shadow-sm"  value="{{ old('nombre') }}"></textarea>
                    </div>

                    <div class="form-group mt-2">
                        <label for="intereses">Intereses</label>
                        <div class="form-check">
                            @foreach ($intereses as $interes)
                                <input 
                                    type="checkbox" name="interes_{{ $loop->index }}" 
                                    id="interes_{{ $loop->index }}" class="form-check-input" 
                                    value="{{ $interes['id'] }}" />
                                <label 
                                    for="{{ $interes['id'] }}" 
                                    class="form-check-label">{{ $interes['nombre'] }}
                                </label>
                                <br />
                            @endforeach
                        </div>
                    </div>

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <div class="mt-3">
                        <input type="submit" value="Enviar" class="btn btn-success">
                        <a href="{{ route('formularios_inicio') }}" class="btn btn-danger ms-2">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection