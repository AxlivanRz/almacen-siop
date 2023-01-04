@extends('sideb')
@section('content')
<div class="row my-5 py-1">
    <div class="col-1"></div>
    <div class="col-9">
      <div class="card">
        <?php $contador = 0; ?>
        <div class="card-body">
            <h5 class="card-title">Vale</h5>
            <div class="row ">
                <div class="form-group row">
                    <div class="form-group col-3">
                        <label>Fecha de solicitado</label>
                        <input class="form-control form-control-sm" type="datetime" value ="{{$vale->fecha}}" disabled>
                    </div>
                    <div class="form-group col-2">
                        <label>Estatus</label>
                        @if ($vale->status == 3)
                        <div class="w-100"></div>
                            <span class="badge rounded-pill bg-primary">
                            Listo para surtir
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-3">
                        @foreach ($usuarios as $usuario )
                            @if ($vale->usuario_id == $usuario->id_usuario)
                            <label>Usuario solicitante</label>
                            <input class="form-control form-control-sm" type="text" value = "{{$usuario->name}} {{$usuario->primer_apellido}}" disabled>
                            @endif
                        @endforeach
                    </div>
                    <div class="form-group col-3">
                        @if ($vale->fecha_aprovado != null)
                        <label>Fecha de aprobado</label>
                        <input class="form-control form-control-sm" type="datetime" value = "{{$vale->fecha_aprovado}}" disabled>
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
                                            <select class="form-control form-control-sm" name="articulokey[]" disabled>                                                    
                                                <option selected value="{{$vArticulo->id}}">
                                                    {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                                </option>                                                    
                                            </select>
                                        @endif
                                    @endif
                                </div>
                                <div class="form-group col-5">
                                    <label>Cantidad</label>
                                    <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad" type="number" min="0" value = "{{$vArticulo->pivot->cantidad}}" disabled>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
{{-- Para surtir --}}
{{-- Para surtir --}}
<div class="row my-5">
    <div class="col-1"></div>
    <div class="col-9">
        <div class="card">
            <?php $contador = 0; ?>
            <div class="card-body">
                <form action="{{route('surtir.update',$surtido->id)}}" method="POST">
                    @csrf 
                    @method('PUT')
                    <h5 class="card-title">Vale Aprobado</h5>
                    <div class="row border-top mt-2">
                        @foreach ($queryEFAs as $queryEFA)
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label>Articulo</label>
                                <input disabled type="text" class="form-control form-control-sm" value="{{$queryEFA->nombre_articulo}} - {{$queryEFA->nombre_med}}">
                            </div>
                            <div class="form-group col-3">
                                <label>Número de factura</label>
                                <input disabled type="number" class="form-control form-control-sm" value="{{$queryEFA->factura_id}}">
                            </div>
                            <div class="form-group col-3">
                                <label>Precio</label>
                                <input disabled type="number" class="form-control form-control-sm" name="precio[]" step="any" value="{{$queryEFA->precio}}">
                            </div>
                            <div class="form-group col-3">
                                <label>Cantidad</label>
                                <input disabled type="number" class="form-control form-control-sm" name= "cantidad[]" value="{{$queryEFA->cantidad}}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row border-top mt-2">
                        <div class="form-group col-4">
                            <label >Total del vale</label>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-sm" id= "total" step="any" name="total" min="0" value="{{$surtido->total}}">
                            </div>
                        </div>
                        <div class="form-group col-2 m-2 py-3">
                            <button type="submit" class="btn btn-success btn-sm" style="display:block">
                                Confirmar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection