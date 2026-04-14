@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <!-- Título y estado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-6 mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>
                    Integración de API pública
                </h2>
                <div>
                    @if($status == 200)
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check-circle me-1"></i> Conectado - Estado: {{ $status }}
                        </span>
                    @else
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-exclamation-circle me-1"></i> Error - Estado: {{ $status }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    @if(isset($users) && count($users) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-table me-2"></i>
                        Lista de Usuarios ({{ count($users) }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">ID</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Website</th>
                                    <th>Ciudad</th>
                                    <th class="text-center">Empresa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $user['id'] }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $user['name'] }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $user['username'] }}</span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user['email'] }}">
                                            {{ $user['email'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <small>{{ $user['phone'] }}</small>
                                    </td>
                                    <td>
                                        <a href="http://{{ $user['website'] }}" target="_blank" class="text-decoration-none">
                                            {{ $user['website'] }}
                                            <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7em;"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $user['address']['city'] }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            {{ $user['company']['name'] }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light py-2">
                    <small class="text-muted">
                        <i class="fas fa-database me-1"></i>
                        Datos obtenidos de: https://jsonplaceholder.typicode.com/users
                    </small>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Sin datos -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning text-center">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h5>No hay usuarios disponibles</h5>
                <p class="mb-0">La API no retornó datos o hubo un error en la conexión.</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection