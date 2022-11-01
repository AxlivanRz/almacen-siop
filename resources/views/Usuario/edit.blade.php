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
                    <label for="basic-url" class="form-label">Rol de usuario</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text"  id="basic-addon2"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" style="height: 37px" name="rol" id="rol">
                            @if ( $us->roles->isNotEmpty())
                                @foreach ( $us->roles as $rol )
                                <option selected value="{{$rol->id_rol}}">
                                    {{$rol->nombre_rol}}
                                </option>
                                @endforeach
                            @endif
                                @foreach ($roles as $rl)
                                    @if ($rol->id_rol != $rl->id_rol)
                                        <option value="{{$rl->id_rol}}">
                                            {{$rl->nombre_rol}}
                                        </option>  
                                    @endif
                                @endforeach
                        </select>
                    </div> 
                    <label> Selecciona a que división pertenece</label>
                    @if ($us->area_id != null)
                        <div class="col-12" id="area" name = "area">
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
                        <div class="col-12" id="area" name = "area">
                            <label>Dirección/Unidad</label>
                            <select class="form-select form-select-sm"  name="areaus" id="areaus">
                                <option value="0" selected>Seleccione una Dirección</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id_area}}">{{$area->nombre_area}}</option>
                                    @endforeach                      
                            </select>
                        </div>
                    @endif
                    <div style="text-align: center">
                    <label>O</label>
                    </div>
                    @if ($us->departamento_id != null)
                        <div class="col-12" id="depa" name = "depa">
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
                        <div class="col-12" id="depa" name = "depa">
                            <label>Departamento</label>
                            <select class="form-select form-select-sm"  name="departamento" id="departamento">
                                <option value="0" selected>Seleccione un Departamento</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{$departamento->id_departamento}}">{{$departamento->nombre_departamento}}</option>
                                @endforeach                 
                            </select>
                        </div> 
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
