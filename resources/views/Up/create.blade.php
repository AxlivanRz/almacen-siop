<!-- Modal -->
<div class="modal fade" id="upCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="upCreateLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="userCreateLabel" >Crear up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <form action="{{route('up.store')}}" method="POST">
                            @csrf
                        <div class="col-12">
                            <label >Nombre </label>                
                            <input type="text mb-3" class="form-control"  id="nombre_up" name="nombre_up" style="height: 35px">
                        </div>
                        <div class="col-12">
                            <label >Descripción</label>
                            <input type="text" class="form-control" id ="desc_up" name ="desc_up" style="height: 35px">
                        </div>
                        <div class="col-12">
                            <label >Iniciales</label>
                            <input type="text" class="form-control" id ="iniciales" name ="iniciales" style="height: 35px">
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