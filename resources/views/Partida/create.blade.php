<!-- Modal -->
<div class="modal fade" id="partidaCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="partidaCreateLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="partidaCreateLabel" >Crear partida presupuestal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class= "row g-3 needs-validation" action="{{route('partida.store')}}" method="POST" novalidate>
                @csrf
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <div class="col-12">
                            <label >Clave partida</label>
                            <input type="text" class="form-control" id ="desc_partida" name ="desc_partida" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Nombre de partida</label>                
                            <input type="text mb-3" class="form-control"  id="nombre_partida" name="nombre_partida" style="height: 35px" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="col-12">
                            <label >Iniciales de partida</label>
                            <input type="text" class="form-control" id ="abreviado" name ="abreviado" style="height: 35px" required>
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