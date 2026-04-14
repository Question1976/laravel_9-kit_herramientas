@extends('layouts.frontend')

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="text-center">
                    <p class="display-6">Fotos del producto</p>
                    <p>Nombre del producto: <span class="fw-bold text-primary">{{ $producto->nombre }}</span></p>                
                </div>   
            </div>
            
            <!-- Mensajes flash -->
            <x-flash />             
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start mb-2">
                <form action="{{ route('bd_productos_fotos_post', ['id' => $producto->id]) }}" method="POST" name="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control shadow-sm" />
                    </div>

                    <!-- Seguridad (protección contra ataques) -->
                    {{ csrf_field() }}

                    <div class="mt-3">
                        <input type="submit" value="Enviar" class="btn btn-success" />
                        <a href="{{ route('bd_productos')}}" class="btn btn-danger ms-2">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 mt-3">
            <div class="table-responsive mb-5">
                <table class="table table-bordered table-striped table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                        <tr>                            
                            <th class="text-center w-75">Foto</th>
                            <th class="text-center w-25">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- registros de la tabla -->
                        @foreach ($fotos as $foto)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('uploads/productos') }}/{{ $foto->nombre }}" alt="Imagen foto" width="100" height="100" />
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" onclick="confirmaAlert('¿Seguro que quieres eliminar la foto?', '{{ route('bd_productos_fotos_delete', ['producto_id' => $producto->id, 'foto_id' => $foto->id]) }}');">
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