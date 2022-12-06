<!-- Modal -->
<div class="modal fade" id="proveedorCreate" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="proveedorCreateLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="userCreateLabel" >Alta de proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class= "row g-3 needs-validation" action="{{route('proveedor.store')}}" method="POST" novalidate>
                @csrf
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <div class="col-12">
                            <label >Razón social</label>                
                            <input type="text mb-3" class="form-control"  id="razon" name="razon" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Nombre de la empresa</label>                
                            <input type="text mb-3" class="form-control"  id="empresa" name="empresa" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Calle</label>
                            <input type="text" class="form-control" id ="calle" name ="calle" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Colonia</label>
                            <input type="text" class="form-control" id ="colonia" name ="colonia" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div> 
                        <div class="col-12">
                            <label >Código postal</label>
                            <input type="text" class="form-control" id ="codigo_postal" name ="codigo_postal" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Población</label>
                            <input type="text" class="form-control" id ="poblacion" name ="poblacion" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>  
                        <div class="col-12">
                            <label >Estado</label>
                            <input type="text" class="form-control" id ="estado" name ="estado" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>  
                        <div class="col-12">
                            <label >País</label>
                            <input type="text" class="form-control" id ="pais" name ="pais" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Télefono</label>
                            <input type="text" class="form-control" id ="telefono" name ="telefono" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>  
                        <div class="col-12">
                            <label >Email</label>
                            <input type="email" class="form-control" id ="email_proveedor" name ="email_proveedor" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
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