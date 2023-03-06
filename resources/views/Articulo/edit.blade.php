@extends('sideb')
@section('content')
<br>
<div class="row mx-5 px-5">
    <div class="col-11">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Articulo</h5>
                <form action="{{route('articulo.update',$articulo->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <div class="form-group col-3">
                            <label >Clave</label>
                            <input type="text" class="form-control form-control-sm" id ="clave" name ="clave" value="{{$articulo->clave_articulo}}" >
                        </div>
                        <div class="form-group col-5">
                            <label >Nombre artículo</label>                
                            <input type="text" class="form-control form-control-sm"  id="nombreAr" name="nombreAr"  value="{{$articulo->nombre_articulo}}">
                        </div>
                        <div class="form-group col-3">
                            <label >Ubicación</label>
                            <input type="text" class="form-control form-control-sm" id ="ubicacion" name ="ubicacion"  value="{{$articulo->ubicacion}}">
                        </div>  
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-3">
                            <label >Observaciones</label>
                            <input type="text" class="form-control form-control-sm" id ="observaciones" name ="observaciones" value="{{$articulo->observaciones}}">
                        </div>                   
                        
                        <div class="form-group col-4 "> 
                            <label >Partida</label>                                         
                            <select class="form-select form-select-sm"  name="partida" id="partida">
                                @foreach ($partidas as $partida )
                                    @if ($partida->id == $articulo->partida_id)  
                                        <option selected value="{{$partida->id}}">{{$partida->nombre_partida}}</option>
                                    @endif
                                @endforeach 
                                @foreach ($partidas as $partida)
                                    @if ($partida->id != $articulo->partida_id)
                                        <option value="{{$partida->id}}">{{$partida->nombre_partida}}</option>
                                    @endif   
                                @endforeach                  
                            </select>
                        </div>  
                        
                        <div class="form-group col-4">    
                            <label >Unidad de medida</label>                                      
                            <select class="form-select form-select-sm"  name="medida" id="medida">
                                @foreach ($medidas as $medida )
                                    @if ($medida->id_medida == $articulo->medida_id)  
                                        <option selected value="{{$medida->id_medida}}">{{$medida->nombre_medida}}</option>
                                    @endif
                                @endforeach 
                                @foreach ($medidas as $medida)
                                    @if ($medida->id_medida != $articulo->medida_id)
                                        <option value="{{$medida->id_medida}}">{{$medida->nombre_medida}}</option>
                                    @endif   
                                @endforeach                  
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-5">
                            @if (isset($articulo->foto_articulo))
                            <div class="col-4 mt-3">
                                <img src="{{asset('storage').'/'.$articulo->foto_articulo}}" alt="Foto de articulo" style="height: 120px;">
                            </div>
                            @endif 
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto del articulo</label>
                                <input class="form-control form-control-sm" id="foto" name="foto" type="file" accept="image/*" >
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                            <div class="modal-footer bg-white border-0">
                                <button type="submit" class="btn btn-outline-primary">Editar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>           
@endsection
