<!-- Modal -->
<div class="modal fade" id="articuloCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="articuloCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="articuloCreateLabel" >Crear artículo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('articulo.store')}}" method="POST">
                        @csrf
                    <div class="col-12">
                        <label >Nombre artículo</label>                
                        <input type="text mb-3" class="form-control"  id="nombreAr" name="nombreAr" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Unidad de medida</label>
                        <input type="text" class="form-control" id ="unidad" name ="unidad" style="height: 35px">
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