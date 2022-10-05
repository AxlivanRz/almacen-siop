<!-- Modal -->
<div class="modal fade" id="encabezadoCreate" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="encabezadoCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm ">
      <div class="modal-content">
        <div class="modal-header bg-white border-0 " style="height: 50px">
          <h5 class="modal-title" id="encabezadoCreateLabel" >Crear encabezado de factura</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="content" style="align-self: center">
                <div class="modal-body">
                    <form action="{{route('encabezado.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="col-12">
                        <label >Fecha</label>
                        <input type="date" class="form-control" id ="fecha" name ="fecha" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Número de factura</label>                
                        <input type="text" class="form-control"  id="numerof" name="numerof" style="height: 35px">
                    </div>
                    <div class="col-12">
                        <label >Folio</label>
                        <input type="text" class="form-control" id ="folio" name ="folio" style="height: 35px">
                    </div>         
                    <label >Proveedores</label>
                    <div class="col-12">                                          
                        <select class="form-select form-select-sm"  name="proveedor" id="proveedor">
                            <option selected>Seleccionar el proveedor</option>
                            @foreach ($proveedores as $proveedor)
                            <option value="{{$proveedor->id_proveedor}}">{{$proveedor->nombre_empresa}}</option>   
                            @endforeach                      
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="archivo" class="form-label">Respaldo de factura</label>
                            <input class="form-control form-control-sm" id="archivo" name="archivo" type="file">
                          </div>
                    </div>                                          
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-outline-success">Crear</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>