@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="col text-center">           
            <p class="display-6">Ruta protegida</p>
            <p>Acceso a información restringida para usuarios registrados que sean Administradores</p>
            <img src="{{ asset('images/webmaster.jpg') }}" alt="Imagen protegida" class="img-fluid" width="200" />            
        </div>
    </div>
@endsection