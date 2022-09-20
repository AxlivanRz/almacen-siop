<!-- Modal -->
<div class="modal fade" id="recursoCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="recursoCreateLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="recursoCreateLabel" >Crear Origen del recurso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <form action="{{route('recurso.store')}}" method="POST">
                            @csrf
                        <div class="col-12">
                            <label >Nombre</label>                
                            <input type="text mb-3" class="form-control"  id="nombre_recurso" name="nombre_recurso" style="height: 35px">
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