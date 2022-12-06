<!-- Modal -->
<div class="modal fade" id="userCreate" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" >
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="userCreateLabel" >Crear usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form class= "row g-3 needs-validation" action="{{route('usuario.store')}}" method="POST" novalidate>
                        @csrf
                    <div class="col-12">
                        <label >Nombre </label>                
                        <input type="text mb-3" class="form-control @error('nombre_us') is-invalid @enderror"  id="nombre_us" name="nombre_us" style="height: 35px" required>
                        <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        @error('nombre_us')
                            <span class="invalid-feedback">
                                <small>
                                    {{$message}}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label >Primer Apellido</label>
                        <input type="text" class="form-control  @error('primer') is-invalid @enderror" id ="primer" name ="primer" style="height: 35px" required>
                        <div class="valid-feedback">Campo completo</div>
                        <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        @error('primer')
                            <span class="invalid-feedback">
                                <small>
                                    {{$message}}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label >Segundo Apellido</label>
                        <input type="text" class="form-control" id ="segundo" name ="segundo" style="height: 35px">
                    </div>
                    <div class="col-12" id="divUsername">
                        <label >Nombre de usuario / username</label>
                        <input type="text" onkeyup="countChars(this);" class="form-control @error('username') is-invalid @enderror" id ="username" name ="username" style="height: 35px" required >
                        <div class="invalid-feedback">Este campo No Puede estar vacío</div> 
                        <div class="invalid-feedback">Debe contener por lo menos 6 caracteres</div>
                        @error('username')
                        <span class="invalid-feedback">
                            <small>
                                {{$message}}
                            </small>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12" id="divContrasena">
                        <label >Contraseña</label>
                        <input type="password" onkeyup="countContra(this);" class="form-control @error('contrasena') is-invalid @enderror" id ="contrasena" name = "contrasena" style="height: 35px" required>
                        <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        <div class="invalid-feedback">Debe contener por lo menos 6 caracteres (Aa1)</div>
                        @error('contrasena')
                        <span class="invalid-feedback">
                            <small>
                                {{$message}}
                            </small>
                        </span>
                        @enderror
                    </div>                    
                    <label for="basic-url" class="form-label">Rol de usuario</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text"  id="basic-addon2"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select @error('rol') is-invalid @enderror" style="height: 37px" name="rol" id="rol" required>    
                            @foreach ($roles as $rol)
                                <option data-rol-id="{{$rol->id_rol}}" data-rol-slug="{{$rol->slug}}"
                                value="{{$rol->id_rol}}">{{$rol->nombre_rol}}</option>  
                            @endforeach
                        </select>
                        @error('rol')
                            <span class="invalid-feedback">
                                <small>
                                    {{$message}}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <label> Selecciona a que área pertenece</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioad" id="radioad" value="1" onchange="javascript:radioac()">
                        <label class="form-check-label" for="1">Dirección/Unidad</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="radioad" id="radioad" value="2" onchange="javascript:radiobc()">
                        <label class="form-check-label" for="2">Departamento</label>
                    </div> 
                    <div class="col-12" id="areac" name = "areac" style="display: none">
                        <select class="form-select form-select-sm @error('areaus') is-invalid @enderror"  name="areaus" id="areaus" required>
                            <option value= "0" selected>Seleccionar al área que pertenece</option>
                            @foreach ($areas as $area)
                            <option value="{{$area->id_area}}">{{$area->nombre_area}}</option>   
                            @endforeach                      
                        </select>
                        @error('areaus')
                            <span class="invalid-feedback">
                                <small>
                                    {{$message}}
                                </small>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12" id="depac" name = "depac" style = "display: none">
                        <select class="form-select form-select-sm @error('departamento') is-invalid @enderror"  name="departamento" id="departamento" required>
                            <option value= "0" selected>Seleccionar al departamento que pertenece</option>
                            @foreach ($departamentos as $departamento)
                            <option value="{{$departamento->id_departamento}}">{{$departamento->nombre_departamento}}</option>   
                            @endforeach                      
                        </select>
                        @error('departamento')
                        <span class="invalid-feedback">
                            <small>
                                {{$message}}
                            </small>
                        </span>
                        @enderror
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
<script type="text/javascript">
    function countChars(obj){
        var div = document.getElementById("divUsername");
        if (obj.value.length >= 6) {
            if ($("#vSeis").length == 0) {
                $(div).append(
                '<div class="valid-feedback" id="vSeis">' + 'Los datos son correctos' + '</div>'
                ); 
            }
        }
        if (obj.value.length < 6) {
            if ($("#vSeis").length > 0) {
                $("#vSeis").last().remove();
            }
        }
    }
    function countContra(obj){
        var divC = document.getElementById("divContrasena");
        if (obj.value.length >= 6) {
            if ($("#cSeis").length == 0) {
                $(divC).append(
                '<div class="valid-feedback" id="cSeis">' + 'Los datos son correctos' + '</div>'
                ); 
            }
        }
        if (obj.value.length < 6) {
            if ($("#cSeis").length > 0) {
                $("#cSeis").last().remove();
            }
        }
    }
    function radioac() {
        element = document.getElementById('radioad').value;
        area = document.getElementById('areac');
        depar = document.getElementById('depac');
        if (element.checked = 1) {
            area.style.display='block';
            depar.style.display='none';        
        }
    }
    function radiobc() {
        element = document.getElementById('radioad').value;
        area = document.getElementById('areac');
        depar = document.getElementById('depac');
        if (element.checked = 2) {
            area.style.display='none';
            depar.style.display='block';              
        }
    }
    (function () {
     'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })()
</script>