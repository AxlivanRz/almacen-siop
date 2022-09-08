<!-- Modal -->
<div class="modal fade" id="partidaEdit{{$partida->id_partida}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="partidaEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-aentered modal-dialog-scrollable">
      <div class="modal-content ">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="partidaEditLabel" >Editar partida</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('partida.update',$partida->id_partida)}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="col-12">
                            <label >Nombre </label>                
                            <input type="text mb-3" class="form-control"  id="nombre_partida" name="nombre_partida" style="height: 35px" value="{{$partida->nombre_partida}}">
                        </div>
                        <div class="col-12">
                            <label >Descripción</label>
                            <input type="text" class="form-control" id ="desc_partida" name ="desc_partida" style="height: 35px" value="{{$partida->descripcion_partida}}">
                        </div>
                        <div class="col-12">
                            <label >Abreviado</label>
                            <input type="text" class="form-control" id ="abreviado" name ="abreviado" style="height: 35px" value="{{$partida->abreviado}}">
                        </div>               
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-primary"> &NonBreakingSpace; Editar &NonBreakingSpace;</button>
                </div>
            </div>
            
        </form>
      </div>
    </div>
</div>