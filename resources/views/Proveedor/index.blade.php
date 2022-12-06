@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-people-carry fa-2x"></i> &NonBreakingSpace; Proveedores</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Razón social</th>
                    <th scope="col">Nombre de la empresa</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Email</th>
                    <th scope="col" style="width: 150px;">Acciones&nbsp;
                        <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#proveedorCreate">
                            <i class="far fa-plus-square"></i>
                        </button>
                    </th>
                    
                </tr>
            </thead>
            <tbody>            
                @if ($proveedores->isNotEmpty())
                    @foreach ( $proveedores as $proveedor )
                        <tr>
                            <th scope="row">{{$proveedor->id_proveedor}}</th>
                            <td>{{$proveedor->razon_social}}</td>
                            <td>{{$proveedor->nombre_empresa}}</td>
                            <td>{{$proveedor->telefono}}</td>
                            <td>{{$proveedor->email_proveedor}}</td>
                            <td >                                
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#proveedorDelete{{$proveedor->id_proveedor}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>                               
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proveedorEdit{{$proveedor->id_proveedor}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button> 
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#proveedorShow{{$proveedor->id_proveedor}}">
                                    <i class="fas fa-eye"></i>
                                </button>                              
                            </td>                   
                        </tr>
                    @endforeach
                @else
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
        <div class = "d-flex">{{$proveedores->links()}}</div> 
    </div>
    @if ($proveedores->isNotEmpty())
        @foreach ( $proveedores as $proveedor )
            @include('Proveedor.delete')
            @include('Proveedor.edit')
            @include('Proveedor.show')
        @endforeach
    @endif
    @include('Proveedor.create')
    @if(Session::has('exito'))
    <script>
        toastr.success("{!! Session::get('exito') !!}");
    </script>
    @endif
    @if(Session::has('no'))
    <script>
        toastr.error("{!! Session::get('no') !!}");
    </script>
    @endif
</div>
@endsection