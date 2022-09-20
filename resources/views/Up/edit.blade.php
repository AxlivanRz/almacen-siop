<!-- Modal -->
<div class="modal fade" id="upEdit{{$up->id_up}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content ">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="upEditLabel" >Editar UP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('up.update',$up->id_up)}}" method="POST">
                        @csrf 
                        @method('PUT')
                        <div class="col-12">
                            <label >Unidad presupuestal</label>
                            <input type="text" class="form-control" id ="desc_up" name ="desc_up" style="height: 35px" value="{{$up->descripcion_ups}}">
                        </div>
                        <div class="col-12">
                            <label >Nombre de la UP </label>                
                            <input type="text mb-3" class="form-control"  id="nombre_up" name="nombre_up" style="height: 35px" value="{{$up->nombre_ups}}">
                        </div>                        
                        <div class="col-12">
                            <label >Iniciales</label>
                            <input type="text" class="form-control" id ="iniciales" name ="iniciales" style="height: 35px" value="{{$up->iniciales}}">
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