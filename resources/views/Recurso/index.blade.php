@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-piggy-bank fa-2x"></i> &NonBreakingSpace; Origen recurso</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col" style="width: 100px;">Acciones&nbsp;
                        <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#recursoCreate">
                            <i class="far fa-plus-square"></i>
                        </button>
                    </th>
                    
                </tr>
            </thead>
            <tbody>            
                @if ($recursos->isNotEmpty())
                    @foreach ( $recursos as $recurso )
                        <tr>
                            <th scope="row">{{$recurso->id_origen}}</th>
                            <td>{{$recurso->nombre_recurso}}</td>
                            <td >                                                           
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#recursoEdit{{$recurso->id_origen}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>                               
                            </td>                   
                        </tr>
                    @endforeach
                @else
                    <td colspan="3" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table> 
        <div class = "d-flex">{{$recursos->links()}}</div>
    </div>
    @if ($recursos->isNotEmpty())
        @foreach ( $recursos as $recurso )
            @include('Recurso.edit')
        @endforeach
    @endif
    @include('Recurso.create')
</div>
@endsection