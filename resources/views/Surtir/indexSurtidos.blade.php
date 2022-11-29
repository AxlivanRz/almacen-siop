@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales Surtidos</h5>
    </div>
</div>
<div class="row">
    <div class="container bg-white col-10">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Fecha de Surtido</th>
                        <th scope="col">Cantidad de articulos</th>
                        <th scope="col">Total del vale</th>
                        <th scope="col">Surtido por</th>
                        <th scope="col">Sección a la que pertenece</th>
                        <th scope="col" style="width: 150px;">Acciones&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($surtidos->isNotEmpty())
                        @foreach ( $surtidos as $surtido )
                            
                            <tr>
                                <th scope="row">{{$surtido->id}}</th>                            
                                <td>{{$surtido->fecha}}</td>
                                <td>Contiene: {{count($surtido->entradas)}} articulos</td>
                                <td>$ {{$surtido->total}}</td>
                                @foreach ($usuarios as $usuario )
                                    @if ($usuario->id_usuario == $surtido->capturista_id)
                                    <td>{{$usuario->name}} {{$usuario->primer_apellido}}</td>
                                    @endif
                                    @if ($usuario->area_id != null)
                                        @foreach ($areas as $area )
                                            @if ($usuario->area_id == $area->id_area)
                                                <td style="text-align: center">{{$area->nombre_area}}</td>
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
                                    <a href="" class="btn btn-info btn-sm" disabled>
                                        <i class="fas fa-eye" style="color: white"></i>
                                    </a>                           
                                </td>                   
                            </tr>     
                            
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