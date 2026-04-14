@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 text-center mt-3">   
                <p class="display-6">Envio de emails en Laravel mediante Mailtrap</p>  
                <x-flash />
                <a href="{{ route('email_enviar') }}" class="btn btn-success">Enviar</a>                        
            </div>
        </div>
    </div>
@endsection