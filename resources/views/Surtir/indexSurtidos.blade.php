@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales Surtidos</h5>
    </div>
    <div class="d-md-flex justify-content-md-end my-3 px-5">
        <form action="/vales/surtidos" method="get">
            <div class="btn-group">
                <input type="text" name="busqueda"  placeholder= "Ingresa el N° de vale surtido" class="form-control form-control-sm">
                <input type="submit" value="Buscar" class="btn btn-sm btn-primary">
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="container bg-white col-10">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th scope="col">N° de vale surtido</th>
                        <th scope="col">Fecha de Surtido</th>
                        <th scope="col">Cantidad de articulos</th>
                        <th scope="col">Total del vale</th>
                        <th scope="col">Surtido por</th>
                        <th scope="col">N° de vale solicitado</th>
                        <th scope="col" style="width: 150px;">Acciones&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($surtidos->isNotEmpty())
                        @foreach ( $surtidos as $surtido )
                            <tr>
                                <th scope="row">{{$surtido->id}}</th>                            
                                <td>{{$surtido->fecha}}</td>
                                <td>{{count($surtido->entradas)}} articulos</td>
                                <td>$ {{$surtido->total}}</td>
                                @foreach ($usuarios as $usuario )
                                    @if ($usuario->id_usuario == $surtido->capturista_id)
                                    <td>{{$usuario->name}} {{$usuario->primer_apellido}}</td>
                                    @endif
                                @endforeach
                                <td>{{$surtido->vale_id}}</td>
                                <td>                                                            
                                    <a href="{{route('surtir.show',$surtido->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye" style="color: white"></i>
                                    </a>    
                                    <a href="{{route('vale.pdf',$surtido->id)}}" class="btn btn-primary btn-sm">
                                       PDF
                                    </a>                           
                                </td>                   
                            </tr>     
                        @endforeach   
                    @endif
                </tbody>
            </table> 
            <div class = "d-flex">{{$surtidos->appends(['busqueda' => $busqueda])}}</div>
        </div>
    </div>
</div>
@endsection