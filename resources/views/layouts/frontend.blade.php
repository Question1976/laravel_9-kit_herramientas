<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <link href="{{asset('images/logo.jpg')}}" rel="icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kit Herramientas</title>
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" />    
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <!-- css blog -->
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet" />
    <!-- JQuery alerts -->
    <link href="{{ asset('css/jquery.alerts.min.css') }}" rel="stylesheet" />
    <!-- Font awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome-5-8/css/all.css') }}" />
    <!-- stacks -->
    @stack('css')
</head>
<body class="d-flex flex-column min-vh-100">  
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('template_inicio') }}">
        <img src="{{ asset('images/webmaster.jpg') }}" width="50" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('template_inicio') }}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('formularios_inicio') }}">Formularios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('email_inicio') }}">E-Mail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('bd_inicio') }}">Base de Datos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('utiles_inicio') }}">Utilidades</a>
          </li>
          <!-- ¿Usuario logueado? -->
          @if(Auth::check())
            <!-- Usuario logueado -->
            <li class="nav-item ms-5">
              <a class="nav-link" href="#">Hola <span class="fw-bold text-primary">{{ Auth::user()->name }} <span class="fw-bold text-success">({{ @session('perfil') }})</span></span></a>
            </li>
            <!-- Validación de perfil en rutas -->
            @if(@session('perfil_id') == 1)
              <li class="nav-item">
                <a class="nav-link fw-bold text-secondary" href="{{ route('protegida_inicio') }}">Protegida</a>
              </li>              
            @endif

            <li class="nav-item">
              <a class="nav-link fw-bold text-secondary" href="{{ route('protegida_otra') }}">Protegida 2</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-bold text-danger" href="javascript:void(0);" onclick="confirmaAlert('¿Desea cerrar la sesión?', '{{ route('acceso_salir') }}');">Cerrar sesión</a>
            </li>
          @else
            <!-- Usuario NO logueado -->
            <li class="nav-item">
              <a class="nav-link" href="{{ route('acceso_login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('acceso_registro') }}">Registro</a>
            </li>
          @endif
          <!-- -->
        </ul>       
      </div>
    </div>
  </nav>
  

  <main class="container">
    <!-- Contenido -->
        @yield('content')
    <!-- / -->
  </main>

  <footer class="blog-footer">
    <p>Desarrollado por <a href="https://sbsweb.netlify.app/" title="Mi web" target="_blank" class="fw-bold text-white">Salvador Belloso Santos</a>
    </p>
  </footer>

  <!-- js -->
  <script src="{{ asset('js/jquery-2.0.0.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/jquery.alerts.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/funciones.js') }}"></script>
  <!-- stacks -->
  @stack('js')
</body>
</html>