@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3"> 
                <div class="text-center">
                    <p class="display-6">Flash</p> 
                    <p>Mostrar un mensaje flash al pulsar en botón</p>
                    <div>
                        <a href="{{ route('formularios_flash2') }}" class="btn btn-primary">Flash</a>                    
                        <a href="{{ route('formularios_inicio') }}" class="btn btn-danger ms-2">Volver</a>
                    </div>
                </div>               
            </div>
        </div>
    </div>
@endsection