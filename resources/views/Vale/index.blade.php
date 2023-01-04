@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales</h5>
    </div>
</div>
<div class="row">
    <div class="col-2"></div>
    <div class="container bg-white col-10">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Fecha de Solicitado</th>
                        <th scope="col">Cantidad de articulos</th>
                        <th scope="col">Estatus</th>
                        <th scope="col" style="width: 150px;">Acciones&nbsp;
                            <a type="button" class="btn btn-tool btn-sm btn-success" href="{{route('vale.create')}}">
                                <i class="far fa-plus-square"></i>
                            </a>
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if ($vales->isNotEmpty())
                        @foreach ( $vales as $vale )
                            @if ($vale->usuario_id == Auth::user()->id_usuario)
                            <tr>
                                <th scope="row">{{$vale->id}}</th>                            
                                <td>{{$vale->fecha}}</td>
                                <td>Contiene: {{count($vale->articulos)}} articulos</td>
                                {{-- If para el Estatus del vale --}}
                                    @if ($vale->status == 1)
                                    <td style="text-align: top"><i class="fa-solid fa-circle fa-2x" style="color: red"></i></td>
                                    @endif
                                    @if ($vale->status == 2)
                                    <td><i class="fa-solid fa-circle fa-2x" style="color: rgb(255, 230, 0)"></i></td>
                                    @endif
                                    @if ($vale->status == 3)
                                    <td><i class="fa-solid fa-circle fa-2x" style="color: rgb(29, 92, 249)"></i></td>
                                    @endif
                                    @if ($vale->status == 4)
                                    <td><i class="fa-solid fa-circle fa-2x" style="color: rgb(2, 187, 42)"></i></td>
                                    @endif
                                {{-- Termino del If para el Estatus del vale --}}
                                <td>                  
                                    @if ($vale->status == 1)                                   
                                    <a href="{{route('vale.edit',$vale->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a> 
                                    @endif
                                    <a href="{{route('vale.show',$vale->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye" style="color: white"></i>
                                    </a>                              
                                </td>                   
                            </tr>     
                            @endif
                        @endforeach   
                    @else
                    <td colspan="5"><span class="badge rounded-pill bg-danger">Aún no solicitas un vale</span></td>
                    @endif      
                </tbody>
            </table> 
        </div>
    </div>
</div>
@endsection