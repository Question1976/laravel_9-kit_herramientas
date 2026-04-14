@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Buscador interno de Productos</p>
                    <p>Resultados para el término: <span class="fw-bold text-primary">{{ $b }}</span></p>
                </div> 
                
                <!-- Buscador -->
                <form action="{{ route('bd_buscador') }}" name="form_buscador" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control shadow-sm" placeholder="Introduce producto a buscar..." name="b" id="b" />
                        <button class="btn btn-primary" type="submit" id="button-addon2" onclick="buscador();" value="{{ isset($b) ? $b : '' }}"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                <!-- Mensajes flash -->
                <x-flash />         
            </div>               
        </div>       
    </div>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">                
                <a href="{{ route('bd_productos_add') }}" class="btn btn-success"><i class="fas fa-check"></i> Crear</a>
                <a href="{{ route('bd_inicio') }}" class="btn btn-danger ms-2">Volver</a>
            </div>

            <div class="table-responsive mt-4 mb-5">
                <table class="table table-bordered table-striped table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Categoría</th>
                            <th>Nombre</th>
                            <th class="text-center">Precio</th>
                            <th>Descripción</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Fotos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- registros de la tabla -->
                        @foreach ($datos as $dato)
                            <tr>
                                <td class="text-center">{{ $dato->id }}</td>
                                <td>
                                    <a href="{{ route('bd_productos_categorias', ['id' => $dato->categorias_id]) }}">{{ $dato->categorias->nombre }}</a>
                                </td>
                                <td class="fw-bold">{{ $dato->nombre }}</td>
                                <td class="text-center">
                                    {{ number_format($dato->precio, 0, '', '.') }}€
                                </td>
                                <td>
                                    {{ substr($dato->descripcion, 0, 30) }}...
                                </td>
                                <td class="text-center">{{ $dato->stock }}</td>
                                <td class="text-center">
                                    {{ Helpers::invierte_fecha($dato->fecha) }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('bd_productos_fotos', ['id' => $dato->id]) }}">
                                        <i class="fas fa-camera"></i>
                                    </a>
                                </td>
                                <!-- acciones | editar y eliminar-->
                                <td class="text-center">
                                    <a href="{{ route('bd_productos_edit', ['id' => $dato->id]) }}" class="ms-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmaAlert('¿Seguro que quiere eliminar el registro?', '{{ route('bd_productos_delete', ['id' => $dato->id]) }}')" class="ms-4">
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