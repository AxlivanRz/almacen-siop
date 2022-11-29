@extends('sideb')
@section('content')
@canany(['isAdmin', 'isTi', 'isAlm'])
<div class="row">
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales / {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->nombre_rol : "" }}</h5>
    </div>
</div>
@endcanany
<div class="row"> 
    @canany(['isAdmin', 'isTi'])
        <div class="col-3">
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
        <div class="col-3">
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
        <div class="col-3">
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
        <div class="col-3">
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
@endsection