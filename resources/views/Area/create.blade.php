<!-- Modal -->
<div class="modal fade" id="areaCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="areaCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="userCreateLabel" >Crear Dirección/Unidad</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('area.store')}}" method="POST">
                        @csrf
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control"  id="nombre_ar" name="nombre_ar" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Siglas</label>
                        <input type="text" class="form-control" id ="desc_ar" name ="desc_ar" style="height: 35px">
                    </div>         
                    <div class="col-12">
                        <label >Responsable del área</label>
                        <input type="text" class="form-control" name="us" id="us" style="height: 35px">
                    </div>
                    <label >Unidad presupuestal</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="up" id="up">
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