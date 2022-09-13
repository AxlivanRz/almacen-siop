<!-- Modal -->
<div class="modal fade" id="areaEdit{{$area->id_area}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="areaEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" >
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="areaEditLabel" >Editar Dirección/Unidad</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('area.update',$area->id_area)}}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control"  id="nombre_ar" name="nombre_ar" style="height: 35px" value="{{$area->nombre_area}}">
                    </div>
                    <div class="col-12">
                        <label >Siglas</label>
                        <input type="text" class="form-control" id ="desc_ar" name ="desc_ar" style="height: 35px" value="{{$area->descripcion_area}}">
                    </div>         
                    <div class="col-12">
                        <label >Responsable del área</label>
                        <input type="text" class="form-control" name="us" id="us" style="height: 35px" value="{{$area->responsable_area}}">
                    </div>
                    <label >Unidad presupuestal</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="area" id="area">
                            <option selected>Seleccionar a que unidad pertence</option>
                            @foreach ($ups as $up)
                            <option value="{{$up->id_up}}">{{$up->nombre_ups}}</option>   
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