@extends('sideb')
@section('content')
<br>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Iniciales</th>
                    <th scope="col" style="width: 150px;">Acciones&nbsp;
                        <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#upCreate">
                            <i class="far fa-plus-square"></i>
                        </button>
                    </th>
                    
                </tr>
            </thead>
            <tbody>            
                @if ($ups->isNotEmpty())
                    @foreach ( $ups as $up )
                        <tr>
                            <th scope="row">{{$up->id_up}}</th>
                            <td>{{$up->nombre_ups}}</td>
                            <td>{{$up->descripcion_ups}}</td>
                            <td>{{$up->iniciales}}</td>
                            <td >                                
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#upDelete{{$up->id_up}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>                               
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#upEdit{{$up->id_up}}">
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
    </div>
    @if ($ups->isNotEmpty())
        @include('Up.delete')
        @include('Up.edit')
    @endif
    @include('Up.create')
</div>
@endsection