<!-- Mostrar mensajes de error para las validaciones -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
    </div>
@endif

<!-- Mostrar mensajes flash desde de la sesión --> 
@if (Session::has('mensaje'))
    <div class="alert alert-{{ Session::get('css') }}" alert-dismissible fade show role="alert">
        {{ Session::get('mensaje')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif 