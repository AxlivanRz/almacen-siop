<!-- Modal -->
<div class="modal fade" id="articuloShow{{$articulo->id_articulo}}" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="articuloShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " >
                <h5 class="modal-title" id="departamentoEditLabel" >Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <div class="col-12">
                        <label >Clave</label>
                        <input type="text" class="form-control" id ="clave" name ="clave" style="height: 35px"value="{{$articulo->clave_articulo}}" disabled>
                    </div>
                    <div class="col-12">
                        <label >Nombre artículo</label>                
                        <input type="text" class="form-control"  id="nombreAr" name="nombreAr" style="height: 35px" value="{{$articulo->nombre_articulo}}" disabled>
                    </div>
                    <div class="col-12">
                        <label >Ubicación</label>
                        <input type="text" class="form-control" id ="ubicacion" name ="ubicacion" style="height: 35px" value="{{$articulo->ubicacion}}" disabled>
                    </div>
                    <div class="col-12">
                        <label >Observaciones</label>
                        <input type="text" class="form-control" id ="observaciones" name ="observaciones" style="height: 35px" value="{{$articulo->observaciones}}" disabled>
                    </div>                   
                    <label >Partida</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="partida" id="partida" disabled>
                            @foreach ($partidas as $partida )
                                @if ($partida->id_partida == $articulo->partida_id)  
                                    <option selected value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>
                                @endif
                            @endforeach                 
                        </select>
                    </div>  
                    <label >Unidad de medida</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="medida" id="medida" disabled>
                            @foreach ($medidas as $medida )
                                @if ($medida->id_medida == $articulo->medida_id)  
                                    <option selected value="{{$medida->id_medida}}">{{$medida->nombre_medida}}</option>
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
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
