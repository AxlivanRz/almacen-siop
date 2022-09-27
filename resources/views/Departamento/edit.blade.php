<!-- Modal -->
<div class="modal fade" id="departamentoEdit{{$departamento->id_departamento}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="departamentoEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="departamentoEditLabel" >Editar departamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('departamento.update',$departamento->id_departamento)}}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control"  id="nombre_dep" name="nombre_dep" style="height: 35px" value="{{$departamento->nombre_departamento}}">
                    </div>
                    <div class="col-12">
                        <label >Siglas</label>
                        <input type="text" class="form-control" id ="desc_dep" name ="desc_dep" style="height: 35px" value="{{$departamento->descripcion_departamento}}">
                    </div>         
                    <div class="col-12">
                        <label >Responsable del departamento</label>
                        <input type="text" class="form-control" name="us" id="us" style="height: 35px" value="{{$departamento->encargado_departamento}}">
                    </div>
                    <label>Área</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="area" id="area">
                            @foreach ($areas as $area )
                            @if ($area->id_area == $departamento->area_id)  
                                <option selected value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                            @endif
                            @endforeach 
                            @foreach ($areas as $area)
                                @if ($area->id_area != $departamento->area_id)
                                    <option value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                                @endif   
                            @endforeach                    
                        </select>
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