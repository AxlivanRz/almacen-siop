<!-- Modal -->
<div class="modal fade" id="medidaEdit{{$medida->id_medida}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="medidaEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content ">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="medidaEditLabel" >Editar Unidad de medición</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('unidadesmedicion.update',$medida->id_medida)}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="col-12">
                            <label >Nombre de la unidad de medida</label>                
                            <input type="text mb-3" class="form-control"  id="medida" name="medida" style="height: 35px" value="{{$medida->nombre_medida}}">
                        </div>                        
                        <div class="col-12">
                            <label >Abreviado</label>
                            <input type="text" class="form-control" id ="abreviado" name ="abreviado" style="height: 35px" value="{{$medida->abreviado}}">
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