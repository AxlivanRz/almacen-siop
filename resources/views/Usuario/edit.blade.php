<!-- Modal -->
<div class="modal fade" id="userEdit{{$us->id_usuario}}" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" >
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="userCreateLabel" >Editar usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('usuario.update',$us->id_usuario)}}" method="POST">
                        @csrf 
                        @method('PUT')
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control"  id="nombre_us" name="nombre_us" style="height: 35px" value="{{$us->nombre}}">
                    </div>
                    <div class="col-12">
                        <label >Primer Apellido</label>
                        <input type="text" class="form-control" id ="primer" name ="primer" style="height: 35px" value="{{$us->primer_apellido}}">
                    </div>
                    <div class="col-12">
                        <label >Segundo Apellido</label>
                        <input type="text" class="form-control" id ="segundo" name ="segundo" style="height: 35px" value="{{$us->segundo_apellido}}">
                    </div>
                    <div class="col-12">
                        <label > Nombre de usuario / username</label>
                        <input type="text" class="form-control" id ="username" name ="username" style="height: 35px" value="{{$us->nombre_usuario}}">
                    </div>
                    <div class="col-12">
                        <label >Contraseña</label>
                        <input type="password" class="form-control" id ="contrasena" name = "contrasena" style="height: 35px">
                    </div>             
                    <input type="tex" hidden value="{{$us->contrasena}}" id="contra2" name="contra2">       
                    <label for="basic-url" class="form-label">Rol de usuario</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text"  id="basic-addon2"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" style="height: 37px" name="rol" id="rol">
                            <option selected>Seleccione un Rol</option>
                            @foreach ($roles as $rl)
                                <option value="{{$rl->id_rol}}">{{$rl->nombre_rol}}</option>  
                            @endforeach
                        </select>
                    </div> 
                    <label> Selecciona a que división pertenece</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="division" value="1" onchange="javascript:radioae()" >
                        <label class="form-check-label" for="1">Dirección/Unidad</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="division" value="2" onchange="javascript:radiobe()" >
                        <label class="form-check-label" for="2">Departamento</label>
                    </div> 
                    @if ($us->area_id != null)
                        <div class="col-12" id="area" name = "area" style="display: block">
                            <label>Dirección/Unidad</label>
                            <select class="form-select form-select-sm"  name="areaus" id="areaus">
                                    @foreach ($areas as $area )
                                    @if ($area->id_area == $us->area_id)  
                                        <option selected value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                                    @endif
                                    @endforeach 
                                    @foreach ($areas as $area)
                                        @if ($area->id_area != $us->area_id)
                                            <option value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                                        @endif   
                                    @endforeach                      
                            </select>
                        </div>
                    @else
                        @if ($us->departamento_id != null)
                        <div class="col-12" id="depa" name = "depa" style = "display: block">
                            <label>Departamento</label>
                            <select class="form-select form-select-sm"  name="departamento" id="departamento">
                                @foreach ($departamentos as $departamento)
                                    @if ($departamento->id_departamento == $us->departamento_id)
                                        <option selected value="{{$departamento->id_departamento}}">{{$departamento->nombre_departamento}}</option>
                                    @endif
                                @endforeach    
                                @foreach ($departamentos as $departamento)
                                    @if ($departamento->id_departamento != $us->departamento_id)
                                        <option value="{{$departamento->id_departamento}}">{{$departamento->nombre_departamento}}</option>
                                    @endif   
                                @endforeach                 
                            </select>
                        </div>   
                        @else
                            <div class="col-12" id="depa" name = "depa" style = "display: none">
                                <label>Departamento</label>
                                <select class="form-select form-select-sm"  name="departamento" id="departamento">
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{$departamento->id_departamento}}">{{$departamento->nombre_departamento}}</option>
                                    @endforeach                 
                                </select>
                            </div> 
                            <div class="col-12" id="area" name = "area" style="display: none">
                                <label>Dirección/Unidad</label>
                                <select class="form-select form-select-sm"  name="areaus" id="areaus">
                                        @foreach ($areas as $area)
                                            <option value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                                        @endforeach                      
                                </select>
                            </div>
                        @endif
                    @endif                 
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
<script type="text/javascript">
    function radioae() {
        element = document.getElementById('division').value;
        area = document.getElementById('area');
        depar = document.getElementById('depa');
        if (element.checked = 1) {
            area.style.display='block';
            depar.style.display='none';
        }
    }
    function radiobe() {
        element = document.getElementById('division').value;
        area = document.getElementById('area');
        depar = document.getElementById('depa');
        if (element.checked = 2) {
            area.style.display='none';
            depar.style.display='block';              
        }
    }
</script>