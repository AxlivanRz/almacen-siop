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
                <th scope="col">username</th>
                <th scope="col">Rol</th>
                <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#userCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>                
            </tr>
            </thead>
            <tbody>            
                @if ($user->isNotEmpty())
                    @foreach ( $user as $us )
                        <tr>
                            <th scope="row">{{$us->id_usuario}}</th>
                            <td>{{$us->nombre}}</td>
                            <td>{{$us->nombre_usuario}}</td>
                            <td>
                            @if ( $us->roles->isNotEmpty())
                                @foreach ( $us->roles as $rol )
                                <span class="badge rounded-pill bg-info">
                                {{$rol->nombre_rol}}
                                </span>
                                @endforeach
                            @else
                                <span class="badge rounded-pill bg-danger">Sin rol</span>
                            @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#userDelete{{$us->id_usuario}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button> 
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userEdit{{$us->id_usuario}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>                   
                        </tr>                        
                    @endforeach
                @else
                    <td colspan="4"><span class="badge rounded-pill bg-danger">Sin usuarios</span></td>
                @endif                            
            </tbody>
        </table>  
    </div>
    @if ($user->isNotEmpty())
        @include('Usuario.delete')
        @include('Usuario.edit')
    @endif
    @include('Usuario.create')    
</div>
@endsection