<!-- Modal -->
<div class="modal fade" id="userCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="width: 450px">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="userCreateLabel" >Crear usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('usuario.store')}}" method="POST">
                        @csrf
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control"  id="nombre_us" name="nombre_us" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Primer Apellido</label>
                        <input type="text" class="form-control" id ="primer" name ="primer" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Segundo Apellido</label>
                        <input type="text" class="form-control" id ="segundo" name ="segundo" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label > Nombre de usuario / username</label>
                        <input type="text" class="form-control" id ="username" name ="username" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Contraseña</label>
                        <input type="password" class="form-control" id ="contrasena" name = "contrasena" style="height: 35px">
                    </div>                    
                    <label for="basic-url" class="form-label">Rol de usuario</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text"  id="basic-addon2"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" style="height: 37px" name="rol" id="rol">
                            <option selected>Seleccione un Rol</option>
                            @foreach ($roles as $rol)
                                <option data-rol-id="{{$rol->id_rol}}" data-rol-slug="{{$rol->slug}}"
                                value="{{$rol->id_rol}}">{{$rol->nombre_rol}}</option>  
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