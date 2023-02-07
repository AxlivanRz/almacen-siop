@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5><i class="fas fa-users fa-2x"></i> &NonBreakingSpace; Usuarios</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Username</th>
                    <th scope="col">Rol</th>
                    <th scope="col">División</th>
                    <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#userCreate">
                            <i class="far fa-plus-square"></i>
                        </button>
                    </th>                
                </tr>
            </thead>
            <tbody>            
                @if ($user->isNotEmpty())
                    @foreach ($user as $us)
                    @if(Auth::user()->roles->first()->id_rol <= $us->roles->first()->id_rol)
                        <tr>
                            <th scope="row">{{$us->id_usuario}}</th>
                            <td>{{$us->name}}</td>
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
                                @if ( $us->area_id != null)
                                    @foreach ($areas as $area )
                                        @if ($area->id_area == $us->area_id)  
                                        <span class="badge rounded-pill bg-info">Dirección - {{$area->nombre_area}}</span>
                                        @endif
                                    @endforeach
                                @else
                                    @if ($us->departamento_id != null)
                                        @foreach ($departamentos as $departamento )
                                            @if ($departamento->id_departamento == $us->departamento_id)  
                                            <span class="badge rounded-pill bg-info">Departamento - {{$departamento->nombre_departamento}}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="badge rounded-pill bg-danger">Sin registros</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userEdit{{$us->id_usuario}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#userDelete{{$us->id_usuario}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button> 
                            </td>                   
                        </tr>    
                    @endif            
                    @endforeach
                @else
                    <td colspan="4"><span class="badge rounded-pill bg-danger">Sin usuarios</span></td>
                @endif                            
            </tbody>
        </table>  
        <div class = "d-flex">{{$user->links()}}</div>
    </div>
    @foreach ( $user as $us )
        @if ($user->isNotEmpty())
            @include('Usuario.delete')
            @include('Usuario.edit')
        @endif 
    @endforeach
    @include('Usuario.create')   
    @if ($errors->isNotEmpty())
        @foreach ( $errors->all() as $nuevo )
        <script>
            toastr.error('{{$nuevo}}');
        </script>
        @endforeach
    @endif
    @if(Session::has('delete'))
    <script>
        toastr.success("{!! Session::get('delete') !!}");
    </script>
    @endif
    @if(Session::has('post'))
    <script>
        toastr.success("{!! Session::get('post') !!}");
    </script>
    @endif
    @if(Session::has('put'))
    <script>
        toastr.info("{!! Session::get('put') !!}");
    </script>
    @endif
</div>

@endsection