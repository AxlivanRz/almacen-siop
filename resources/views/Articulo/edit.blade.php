<!-- Modal -->
<div class="modal fade" id="articuloEdit{{$articulo->id}}" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="articuloEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " >
                <h5 class="modal-title" id="departamentoEditLabel">Editar artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('articulo.update',$articulo->id)}}" method="POST" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <div class="col-12">
                            <label >Clave</label>
                            <input type="number" class="form-control" id ="clave" name ="clave" style="height: 35px"value="{{$articulo->clave_articulo}}" min="0" step="any">
                        </div>
                        <div class="col-12">
                            <label >Nombre artículo</label>                
                            <input type="text" class="form-control"  id="nombreAr" name="nombreAr" style="height: 35px" value="{{$articulo->nombre_articulo}}">
                        </div>
                        <div class="col-12">
                            <label >Ubicación</label>
                            <input type="text" class="form-control" id ="ubicacion" name ="ubicacion" style="height: 35px" value="{{$articulo->ubicacion}}">
                        </div>
                        <div class="col-12">
                            <label >Observaciones</label>
                            <input type="text" class="form-control" id ="observaciones" name ="observaciones" style="height: 35px" value="{{$articulo->observaciones}}">
                        </div>                   
                        <label >Partida</label>
                        <div class="col-12">                                          
                            <select class="form-select form-select-sm"  name="partida" id="partida">
                                @foreach ($partidas as $partida )
                                    @if ($partida->id_partida == $articulo->partida_id)  
                                        <option selected value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>
                                    @endif
                                @endforeach 
                                @foreach ($partidas as $partida)
                                    @if ($partida->id_partida != $articulo->partida_id)
                                        <option value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>
                                    @endif   
                                @endforeach                  
                            </select>
                        </div>  
                        <label >Unidad de medida</label>
                        <div class="col-12">                                          
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
                        <br>  
                        <div class="col-12">
                            @if (isset($articulo->foto_articulo))
                            <div class="col-8">
                                <img src="{{asset('storage').'/'.$articulo->foto_articulo}}" alt="Foto de articulo" style="height: 120px;">
                            </div>
                            @endif 
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto del articulo</label>
                                <input class="form-control form-control-sm" id="foto" name="foto" type="file" accept="image/*" >
                            </div>
                        </div>  
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                    <div class="modal-footer bg-white border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                        <button type="submit" class="btn btn-outline-primary">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
