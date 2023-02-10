@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-cubes fa-2x"></i> &NonBreakingSpace; Articulos</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-12">
    <div class="table-responsive">
        <table class="table ">
            <thead>
            <tr>
                <th scope="col">Clave</th>
                <th scope="col">Nombre</th>
                <th scope="col">Unidad de medida</th>
                <th scope="col">Partida</th>
                <th scope="col" style="width: 150px;">
                    Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </th>     
                <th scope="col-1">
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#articuloCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>          
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
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#articuloEdit{{$articulo->id}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#articuloShow{{$articulo->id}}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>       
                            <td></td>            
                        </tr>                    
                    @endforeach
                @else
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
        <div class = "d-flex">{{$articulos->links()}}</div>
    </div>
    @if ($articulos->isNotEmpty())  
        @foreach ($articulos as $articulo )
            @include('Articulo.edit')   
            @include('Articulo.show')   
        @endforeach
    @endif
    @include('Articulo.create') 
    @if ($errors->isNotEmpty())
        @foreach ( $errors->all() as $nuevo )
        <script>
            toastr.error('{{$nuevo}}');
        </script>
        @endforeach
    @endif
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