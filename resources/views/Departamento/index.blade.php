@extends('sideb')
@section('content')
<br>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table ">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripción</th>
                <th scope="col">Encargado</th>
                <th scope="col">Área</th>
                <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#departamentoCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>               
            </tr>
            </thead>
            <tbody>            
                @if ($departamentos->isNotEmpty())
                    @foreach ($departamentos as $departamento)
                        <tr>
                            <th scope="row">{{$departamento->id_departamento}}</th>
                            <td>{{$departamento->nombre_departamento}}</td>
                            <td>{{$departamento->descripcion_departamento}}</td>
                            @foreach ($usuarios as $usuario )
                                @if ($usuario->id_usuario == $departamento->usuario_id)
                                <td>{{$usuario->nombre_usuario}}</td>                                 
                                @else
                                <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de usuario</span></td> 
                                @endif
                            @endforeach
                            @foreach ($areas as $area )
                                @if ($area->id_area == $departamento->area_id)  
                                <td>{{$departamento->nombre_departamento}}</td>                              
                                @else
                                <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                                @endif
                            @endforeach                                                
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#departamentoDelete{{$departamento->id_departamento}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button> 
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#departamentoEdit{{$departamento->id_departamento}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>                   
                        </tr>                       
                    @endforeach
                @else
                    <td colspan="5" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
    </div>  
    @if ($departamentos->isNotEmpty())       
        @include('Departamento.edit')
        @include('Departamento.delete')
    @endif
    @include('Departamento.create')
</div>
@endsection