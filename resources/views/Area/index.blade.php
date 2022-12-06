@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-university fa-2x"></i> &NonBreakingSpace; Direcciones/Unidades</h5>
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
                <th scope="col">Unidad presupuestal</th>
                <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#areaCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>               
            </tr>
            </thead>
            <tbody>            
                @if ($areas->isNotEmpty())
                    @foreach ( $areas as $area )
                        <tr>
                            <th scope="row">{{$area->id_area}}</th>
                            <td>{{$area->nombre_area}}</td>
                            <td>{{$area->descripcion_area}}</td>
                            <td>{{$area->encargado_area}}</td>
                            @foreach ($ups as $up )
                                @if ($up->id_up == $area->up_id)  
                                 <td>{{$up->nombre_ups}}</td>                              
                                @else
                                    @if ($area->up_id == null)
                                        <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                                    @endif
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
                    @endforeach
                @else
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
        <div class = "d-flex">{{$areas->links()}}</div>
    </div>
    @if ($areas->isNotEmpty())  
        @foreach ($areas as $area )
            @include('Area.delete')
            @include('Area.edit')   
        @endforeach
    @endif
    @include('Area.create')   
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