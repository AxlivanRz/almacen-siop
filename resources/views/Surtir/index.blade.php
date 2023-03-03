@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales </h5>
    </div>
</div>
<div class="row">
    <div class="container bg-white col-10">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Cantidad de articulos</th>
                        <th scope="col">Total del vale</th>
                        <th scope="col" style="width: 150px;">Acciones&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($surtidos->isNotEmpty())
                        @foreach ($surtidos as $surtido)
                            @foreach ($vales as $vale)
                                @if ($vale->id == $surtido->vale_id && $vale->status == 3)
                                    <tr>
                                        <th scope="row">{{$surtido->id}}</th>                            
                                        <td>{{count($surtido->entradas)}} articulos</td>
                                        <td>$ {{$surtido->total}}</td>
                                        <td>                                                            
                                            <a href="{{route('surtir.editAlm',$surtido->id)}}" class="btn btn-success btn-sm">
                                                Confirmar &nbsp; <i class="fa-solid fa-up-right-from-square"></i>
                                            </a>                          
                                        </td>                   
                                    </tr>
                                @endif
                            @endforeach     
                        @endforeach   
                    @else
                    <td colspan="4" style="text-align: center"><span class="badge rounded-pill bg-danger">Aún no solicitan un vale</span></td>
                    @endif
                </tbody>
            </table> 
        </div>
    </div>
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