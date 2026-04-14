@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Formulario de upload de archivos</p> 
                    <p>Envio de archivos al servidor, en este caso archivos de tipo imagen</p>
                </div>  
                
                <!-- Mostrar mensajes de error para las validaciones | componente 'flash' -->
                <x-flash />
                
                <!-- enctype="multipart/form-data" | imprescindinble para subir archivos -->
                <form action="{{ route('formularios_upload_post') }}" method="POST" name="form" class="mb-5" enctype="multipart/form-data">
                    
                    <div class="form-group mt-2">
                        <label for="foto">Archivo</label>
                        <input type="file" name="foto" id="foto" class="form-control shadow-sm" />
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