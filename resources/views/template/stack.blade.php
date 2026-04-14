@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 text-center mt-3">   
                <p class="display-6">Ejemplo de stack y push</p>  
                <p>Ejemplo: Cargar librería Fancybox sólo en esta vista</p>
                <a href="{{ asset('images/yoda.png') }}" class="fancybox">
                    <img src="{{ asset('images/yoda.png') }}" alt="Imagen Yoda" width="100" />     
                </a>                                   
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('fancybox/jquery.fancybox.css') }}" />
@endpush

@push('js')
    <script src="{{ asset('fancybox/jquery.fancybox.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect : 'none',
                closeEffect : 'none',
            });
        });
    </script>
@endpush