@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Utilidades</p>
                    <p>Reportes en PDF y Excel así como integración de API externa mediante la librería 'guzzlehttp'</p>                
                </div>   
            </div>
            <ul>
                <li>
                    <a href="{{ route('utiles_pdf') }}" class="fw-bold">Reporte PDF</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('utiles_excel') }}" class="fw-bold">Reporte Excel</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('utiles_cliente_rest') }}" class="fw-bold">Integración API externa privada</a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('utiles_cliente_rest_publica') }}" class="fw-bold">Integración API externa pública</a>
                </li>
            </ul>
        </div>
    </div>
@endsection