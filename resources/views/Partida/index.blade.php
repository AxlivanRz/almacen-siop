@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5><i class="far fa-file-alt fa-2x"></i>&NonBreakingSpace; Partidas presupuestales</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Clave partida</th>
                <th scope="col">Nombre de partida</th>
                <th scope="col">Iniciales de partida</th>
                <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#partidaCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>                
            </tr>
            </thead>
            <tbody>            
                @if ($partidas->isNotEmpty())
                    @foreach ( $partidas as $partida )
                        <tr>
                            <th scope="row">{{$partida->id_partida}}</th>
                            <td>{{$partida->descripcion_partida}}</td>
                            <td>{{$partida->nombre_partida}}</td>
                            <td>{{$partida->abreviado}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#partidaEdit{{$partida->id_partida}}">
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
        <div class = "d-flex">{{$partidas->links()}}</div>
    </div>
    @if ($partidas->isNotEmpty())
        @foreach ( $partidas as $partida )
            @include('Partida.edit')
        @endforeach
    @endif
    @include('Partida.create')
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