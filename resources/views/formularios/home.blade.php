@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Formularios</p> 
                    <p>Crear formularios, seguridad, validación, mensajes flash y subir archivos al servidor</p>                    
                </div>           
                <ul>
                    <li>
                        <a href="{{ route('formularios_simple') }}" class="fw-bold">Formulario simple</a>
                    </li>
                    <li class="mt-2">
                        <a href="{{ route('formularios_flash') }}" class="fw-bold">Formulario mensajes flash</a>
                    </li>
                    <li class="mt-2">
                        <a href="{{ route('formularios_upload') }}" class="fw-bold">Formulario upload archivos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection