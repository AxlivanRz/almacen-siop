@extends('sideb')
@section('content')
@canany(['isAdmin', 'isTi', 'isAlm'])
<style type="text/css"> 
    thead{ 
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #ffffff;
    }

    .table-responsive { 
        height:250px;
        overflow:scroll;
    }
</style>
<div class="row">
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales / {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->nombre_rol : "" }}</h5>
    </div>
</div>
@endcanany
<div class="row" style="background-color: white"> 
    @canany(['isAdmin', 'isTi'])
        <div class="col-md-3 d-flex p-4">
            <div class="card text-white bg-danger">
                <div class="card-header border-0" style="text-align: center">En espera de confirmación de un Administrador</div>
                <div class="card-body"  style="text-align: center">
                    <i class="fa-solid fa-triangle-exclamation fa-5x"></i>                        
                    <p >
                        <a class="card-text" style="color: white" href="{{route('surtir.indexAdmin')}}">Cantidad de vales: {{count($statusUno)}}</a>
                    </p>                                         
                </div>
            </div>
        </div>
    @endcanany
    @canany(['isAdmin', 'isTi', 'isAlm'])
        <div class="col-md-3 p-4">
            <div class="card text-dark bg-warning">
                <div class="card-header border-0" style="text-align: center; color: white">En espera de confirmación del usuario</div>
                <div class="card-body" style="text-align: center">
                    <i class="fa-solid fa-exclamation fa-5x" style="color: white"></i>
                    <p >
                        <a class="card-text" style="color: white">Cantidad de vales: {{count($statusDos)}}</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-4">
            <div class="card text-white bg-primary">
                <div class="card-header border-0" style="text-align: center">Listos para surtir</div>
                <div class="card-body" style="text-align: center">
                    <i class="fa-regular fa-clock fa-5x"></i>
                    <p>
                        <a class="card-text" style="color: white" href="{{route('surtir.index')}}">Cantidad de vales: {{count($statusTres)}}</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3 p-4">
            <div class="card text-white bg-success">
                <div class="card-header border-0" style="text-align: center">Surtidos</div>
                <div class="card-body" style="text-align: center">
                    <i class="fa-solid fa-check fa-5x"></i>
                    <p>
                        <a class="card-text" style="color: white" href="{{route('surtir.indexSurtido')}}">Cantidad de vales: {{count($surtido)}}</a>
                    </p>
                </div>
            </div>
        </div>
    @endcanany
</div>
@canany(['isAdmin', 'isTi', 'isAlm'])
<div class="row">
    <div class="col-3 py-2 mx-3 mt-2">
        <h5> <i class="fas fa-cubes fa-2x"></i> &NonBreakingSpace; Existencias</h5>
    </div>
</div>
<div class="container bg-white col-md-12 col-sm-12 col-11" style="height: 250px;overflow-y: scroll;">
    <div class="table-responsive" >
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th class="header" scope="col">Clave articulo</th>
                <th class="header" scope="col">Nombre</th>
                <th class="header" scope="col">Unidad de medida</th>
                <th class="header" scope="col">Partida</th>     
                <th class="header" scope="col">N. de Factura</th>
                <th class="header" scope="col">Precio</th>
                <th class="header" scope="col">Existencia</th>
                <th class="header" scope="col">Caducidad</th>       
            </tr>
            </thead>
            <tbody>            
                @if ($articulos->isNotEmpty())
                    @foreach ( $articulos as $articulo )
                        <tr>
                            <th scope="row">{{$articulo->clave_articulo}}</th>
                            <td>{{$articulo->nombre_articulo}}</td>
                            <td>{{$articulo->nombre_med}}</td> 
                            @foreach ($partidas as $partida )
                                @if ($partida->id_partida == $articulo->partida_id)  
                                 <td>{{$partida->nombre_partida}}</td>                              
                                @else
                                    @if ($articulo->partida_id == null)
                                        <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                                    @endif
                                @endif
                            @endforeach    
                            <td>{{$articulo->factura_id}}</td>
                            <td>${{$articulo->precio}}</td>
                            <td>{{$articulo->existencia}}</td>     
                            @if ($articulo->caducidad != null)
                            <td>{{$articulo->caducidad}}</td> 
                            @else
                            <td>S/C</td> 
                            @endif  
                        </tr>                 
                    @endforeach
                @else
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
    </div>
</div>
@endcanany
<br>    
@endsection