@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Categorías</p>
                    <p>Tabla con las operaciones CRUD para las categorías de los productos</p>                                   
                </div> 

                <!-- Mensajes flash -->
                <x-flash />         
            </div>               
        </div>       
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                    <a href="{{ route('bd_categorias_add') }}" class="btn btn-success"><i class="fas fa-check"></i> Crear</a>
                    <a href="{{ route('bd_inicio') }}" class="btn btn-danger ms-2">Volver</a>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Nombre</th>
                            <th class="w-25 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- registros de la tabla -->
                        @foreach ($datos as $dato)
                            <tr>
                                <td class="text-center">{{ $dato->id }}</td>
                                <td class="fw-bold">{{ $dato->nombre }}</td>
                                <!-- acciones | editar y eliminar-->
                                <td class="w-25 text-center">
                                    <a href="{{ route('bd_categorias_edit', ['id' => $dato->id]) }}" class="ms-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmaAlert('¿Seguro que quiere eliminar el registro?', '{{ route('bd_categorias_delete', ['id' => $dato->id]) }}')" class="ms-4">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection