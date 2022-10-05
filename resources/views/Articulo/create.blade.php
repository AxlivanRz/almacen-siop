<!-- Modal -->
<div class="modal fade" id="articuloCreate" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="articuloCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
      <div class="modal-content">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="articuloCreateLabel" >Crear artículo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('articulo.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="col-12">
                        <label >Clave</label>
                        <input type="text" class="form-control" id ="clave" name ="clave" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Nombre artículo</label>                
                        <input type="text mb-3" class="form-control"  id="nombreAr" name="nombreAr" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Ubicación</label>
                        <input type="text" class="form-control" id ="ubicacion" name ="ubicacion" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Observaciones</label>
                        <input type="text" class="form-control" id ="observaciones" name ="observaciones" style="height: 35px">
                    </div>
                    <label >Unidad de medida</label>
                    <div class="col-12">
                        <select class="form-select form-select-sm"  name="medida" id="medida">
                            <option selected>Seleccionar a la partida que pertenece</option>
                            @foreach ($medidas as $medida)
                            <option value="{{$medida->id_medida}}">{{$medida->nombre_medida}}</option>   
                            @endforeach                      
                        </select>
                    </div>                    
                    <label >Partida</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="partida" id="partida">
                            <option selected>Seleccionar a la partida que pertenece</option>
                            @foreach ($partidas as $partida)
                            <option value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>   
                            @endforeach                      
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="foto_articulo" class="form-label">Foto del articulo</label>
                            <input class="form-control form-control-sm" id="foto_articulo" name="foto_articulo" type="file" accept="image/png, image/jpeg" >
                          </div>
                    </div>                                          
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <button type="submit" class="btn btn-outline-success">Crear</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>