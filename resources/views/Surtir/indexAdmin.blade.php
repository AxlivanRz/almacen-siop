@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales</h5>
    </div>
</div>
<div class="row">
    <div class="container bg-white col-10">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Fecha de Solicitado</th>
                        <th scope="col">Cantidad de articulos</th>
                        <th scope="col">Solicitante</th>
                        <th scope="col">Sección a la que pertenece</th>
                        <th scope="col" style="width: 150px;">Acciones&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vales->isNotEmpty())
                        @foreach ( $vales as $vale )
                            @if ($vale->status == 1)
                            <tr>
                                <th scope="row">{{$vale->id}}</th>                            
                                <td>{{$vale->fecha}}</td>
                                <td>Contiene: {{count($vale->articulos)}} articulos</td>
                                @foreach ($usuarios as $usuario )
                                    @if ($usuario->id_usuario == $vale->usuario_id)
                                    <td>{{$usuario->name}} {{$usuario->primer_apellido}}</td>
                                    @endif
                                    @if ($usuario->area_id != null)
                                        @foreach ($areas as $area )
                                            @if ($usuario->area_id == $area->id_area)
                                                <td>{{$area->nombre_area}}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if ($usuario->departamento_id != null)
                                        @foreach ($departamentos as $departamento )
                                            @if ($usuario->departamento_id == $departamento->id_departamento)
                                                <td>{{$departamento->nombre_departamento}}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                <td>                                                            
                                    <a href="{{route('surtir.editAdmin',$vale->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>                              
                                </td>                   
                            </tr>     
                            @endif
                        @endforeach   
                    @else
                    <td colspan="5"><span class="badge rounded-pill bg-danger">Aún no solicitan un vale</span></td>
                    @endif
                </tbody>
            </table> 
        </div>
    </div>
</div>
@endsection