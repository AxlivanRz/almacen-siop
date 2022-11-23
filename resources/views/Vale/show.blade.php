@extends('sideb')
@section('content')
<div class="row my-5 py-2 ">
    <div class="col-2"></div>
    <div class="col-8">
      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Información del Vale</h5>
        <form action="{{route('vale.submit',$vale->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="row ">
                <div class="form-group row">
                    <div class="form-group col-4">
                        <label>Fecha de solicitado</label>
                        <input class="form-control" type="datetime" value = "{{$vale->fecha}}" disabled>
                    </div>
                    <div class="form-group col-4">
                        <label>Estatus</label>
                        @if ($vale->status == 1)
                        <input class="form-control" type="text" value = "Enviado" disabled>
                        @endif
                        @if ($vale->status == 2)
                        <input class="form-control" type="text" value = "Validado por el Administrador" disabled>
                        @endif
                        @if ($vale->status == 4)
                        <input class="form-control" type="text" value = "Surtido por Almacén" disabled>
                        @endif
                    </div>
                    <div class="form-group col-4">
                        @if ($vale->fecha_aprovado != null)
                        <label>Fecha de aprobado</label>
                        <input class="form-control" type="datetime" value = "{{$vale->fecha_aprovado}}" disabled>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    @foreach ($valeArticulos as $vArticulo)
                        <div id="newpro" name= "newpro" class="newpro">
                            <h5 class="border-top mt-4">Producto</h5>
                            <div class="row d-flex align-items-end"> 
                                <div class="form-group col-5">
                                    @if ($vale->articulos->isNotEmpty())
                                        @if ($valeArticulos !=null)
                                            <label>Articulo</label> 
                                            <select class="form-control" name="articulokey[]" disabled>                                                    
                                                <option selected value="{{$vArticulo->id}}">
                                                    {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                                </option>                                                    
                                            </select>
                                        @endif
                                    @endif
                                </div>
                                <div class="form-group col-5">
                                    <label>Cantidad</label>
                                    <input class="form-control" name="cantidadkey[]" id="cantidad" type="number" min="0" value = "{{$vArticulo->pivot->cantidad}}" disabled>
                                </div>
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