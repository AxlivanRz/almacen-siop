@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-university fa-2x"></i> &NonBreakingSpace; Departamento</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table ">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nombre</th>
                <th scope="col">Siglas</th>
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
                            <td>{{$departamento->encargado_departamento}}</td>
                            @foreach ($areas as $area )
                                @if ($area->id_area == $departamento->area_id)  
                                <td>{{$area->nombre_area}}</td>                              
                                @else
                                @if ( $departamento->area_id == null)
                                <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de área</span></td> 
                                @endif
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
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
    </div>  
    @if ($departamentos->isNotEmpty())   
        @foreach ($departamentos as $departamento)
            @include('Departamento.edit')
            @include('Departamento.delete')
        @endforeach
    @endif
    @include('Departamento.create')
</div>
@endsection