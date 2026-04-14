@extends('layouts.frontend')

@section('content')
    <div class="row">
        <div class="col text-center">           
            <p class="display-6">Ruta protegida 2</p>
            <p>Acceso a información restringida</p>
            <img src="{{ asset('images/yoda.png') }}" alt="Imagen protegida" class="img-fluid" width="200" />            
        </div>
    </div>
@endsection