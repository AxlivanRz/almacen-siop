@extends('sideb')
@section('content')
<div class="row my-5 py-2 ">
    <div class="col-2"></div>
    <div class="col-10">
      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Información del Vale</h5>
        <form action="{{route('vale.submit',$vale->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row ">
                <div class="form-group row">
                    <div class="form-group col-2">
                        <label>Fecha de solicitado</label>
                        <input class="form-control form-control-sm" type="datetime" value = "{{$vale->fecha}}" disabled>
                    </div>
                    <div class="form-group col-2">
                        <label>Estatus</label>
                        @if ($vale->status == 1)
                        <div class="w-100"></div>
                        <span class="badge rounded-pill bg-danger">
                            Enviado
                        </span>
                        @endif
                        @if ($vale->status == 2)
                        <div class="w-100"></div>
                        <span class="badge rounded-pill bg-warning">
                            Validado por el Administrador
                        </span>
                        @endif
                        @if ($vale->status == 3)
                        <div class="w-100"></div>
                        <span class="badge rounded-pill bg-primary">
                            Validado por el solicitante
                        </span>
                        @endif
                        @if ($vale->status == 4)
                        <div class="w-100"></div>
                        <span class="badge rounded-pill bg-success">
                            Surtido por Almacén
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-3">
                        @if ($vale->fecha_aprovado != null)
                        <label>Fecha de aprobado</label>
                        <input class="form-control form-control-sm" type="datetime" value ="{{$vale->fecha_aprovado}}" disabled>
                        @endif
                    </div>
                    @if ($surtido->fecha != null)
                        <div class="form-group col-3">
                            <label>Fecha de surtido</label>
                            <input class="form-control form-control-sm" type="datetime" value ="{{$surtido->fecha}}" disabled>
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    @foreach ($valeArticulos as $vArticulo)
                        <div id="newpro" name= "newpro" class="newpro">
                            <h5 class="border-top mt-4">Producto</h5>
                            <div class="row d-flex align-items-end"> 
                                <div class="form-group col-8">
                                    @if ($vale->articulos->isNotEmpty())
                                        @if ($valeArticulos !=null)
                                            <label>Articulo</label> 
                                            <select class="form-control form-control-sm" name="articulokey[]" disabled>                                                    
                                                <option selected value="{{$vArticulo->id}}">
                                                    {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                                </option>                                                    
                                            </select>
                                        @endif
                                    @endif
                                </div>
                                <div class="form-group col-2">
                                    <label>Cantidad solicitada</label>
                                    <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad" type="number" min="{{$vArticulo->pivot->cantidad}}" value = "{{$vArticulo->pivot->cantidad}}" disabled>
                                </div>
                                @if ($queryEFAs != null)
                                    @foreach ($queryEFAs as $queryEFA)
                                        @if ($queryEFA->clave_articulo == $vArticulo->clave_articulo)
                                            <div class="form-group col-2">
                                                <label>Cantidad aprobada</label>
                                                <input class="form-control form-control-sm" name="cantidadkey2[]" id="cantidad2" type="number" value = "{{$queryEFA->cantidad }}" disabled>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if ($vale->status == 2)
                    <div class="form-group col-2 my-2">
                        <button type="submit" class="btn btn-success">Confirmar</button>
                    </div>
                    @endif
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>
@endsection