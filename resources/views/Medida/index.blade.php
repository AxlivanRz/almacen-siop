@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5><i class="fas fa-ruler-combined fa-2x"></i> &NonBreakingSpace; Unidades de medida</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Unidad de medida</th>
                    <th scope="col">Abreviado</th>
                    <th scope="col" style="width: 150px;">Acciones&nbsp;
                        <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#medidaCreate">
                            <i class="far fa-plus-square"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>            
                @if ($medidas->isNotEmpty())
                    @foreach ( $medidas as $medida )
                        <tr>
                            <th scope="row">{{$medida->id_medida}}</th> 
                            <td>{{$medida->nombre_medida}}</td>
                            <td>{{$medida->abreviado}}</td>
                            <td >                                                            
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#medidaEdit{{$medida->id_medida}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>                               
                            </td>                   
                        </tr>
                    @endforeach
                @else
                    <td colspan="4" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table> 
        <div class = "d-flex">{{$medidas->links()}}</div>
    </div>
    @if ($medidas->isNotEmpty())
        @foreach ( $medidas as $medida )
            @include('Medida.edit')
        @endforeach
    @endif
    @include('Medida.create')
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