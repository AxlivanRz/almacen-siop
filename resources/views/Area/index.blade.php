@extends('sideb')
@section('content')
<br>
<div class="container bg-white col-md-10 d-inline-flex">
    <table class="table col-md-10">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripción</th>
            <th scope="col">Encargado</th>
            <th scope="col">Unidad presupuestal</th>
            <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#areaCreate">
                    <i class="far fa-plus-square"></i>
                </button>
            </th>
            @include('Area.create')
          </tr>
        </thead>
        <tbody>            
            @if ($areas->isNotEmpty())
                @foreach ( $areas as $area )
                    <tr>
                        <th scope="row">{{$area->id_area}}</th>
                        <td>{{$area->nombre_area}}</td>
                        <td>{{$area->descripcion_area}}</td>
                        @foreach ($usuarios as $usuario )
                            @if ($usuario->id_usuario == $area->usuario_id)
                            <td>{{$usuario->nombre_usuario}}</td>                                 
                            @else
                            <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de usuario</span></td> 
                            @endif
                        @endforeach
                        @foreach ($ups as $up )
                            @if ($up->id_up == $area->up_id)  
                            <td>{{$up->nombre_up}}</td>                              
                            @else
                            <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                            @endif
                        @endforeach                                                
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#areaDelete{{$area->id_area}}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button> 
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#areaEdit{{$area->id_area}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        </td>                   
                    </tr>
                    @include('Area.delete')
                    @include('Area.edit')
                @endforeach
            @else
                <td colspan="5" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
            @endif                            
        </tbody>
    </table>  
</div>
@endsection