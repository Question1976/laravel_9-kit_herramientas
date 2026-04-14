@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="col text-center">           
            <p class="display-6">Ruta protegida sin acceso</p>
            <p>Sin acceso a esta información, esta ruta está protegida para usuarios que no son Administradores</p>
            <img src="{{ asset('images/yoda.png') }}" alt="Imagen protegida" class="img-fluid" width="200" />            
        </div>
    </div>
@endsection