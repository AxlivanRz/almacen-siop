<div class="modal fade" id="proveedorShow{{$proveedor->id_proveedor}}" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="proveedorShowLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " style="height: 50px">
                <h5 class="modal-title" id="proveedorEditLabel" >Datos proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <div class="col-12">
                            <label >Razón social</label>                
                            <input type="text mb-3" class="form-control"  id="razon" name="razon" style="height: 35px" value="{{$proveedor->razon_social}}" disabled>
                        </div>
                        <div class="col-12">
                            <label >Nombre de la empresa</label>                
                            <input type="text mb-3" class="form-control"  id="razon" name="razon" style="height: 35px" value="{{$proveedor->nombre_empresa}}" disabled>
                        </div>
                        <div class="col-12">
                            <label >Calle</label>
                            <input type="text" class="form-control" id ="calle" name ="calle" style="height: 35px" value="{{$proveedor->calle}}" disabled>
                        </div>
                        <div class="col-12">
                            <label >Colonia</label>
                            <input type="text" class="form-control" id ="colonia" name ="colonia" style="height: 35px" value="{{$proveedor->colonia}}" disabled>
                        </div> 
                        <div class="col-12">
                            <label >Código postal</label>
                            <input type="text" class="form-control" id ="codigo_postal" name ="codigo_postal" style="height: 35px" value="{{$proveedor->codigo_postal}}" disabled>
                        </div>
                        <div class="col-12">
                            <label >Población</label>
                            <input type="text" class="form-control" id ="poblacion" name ="poblacion" style="height: 35px" value="{{$proveedor->poblacion}}" disabled>
                        </div>  
                        <div class="col-12">
                            <label >Estado</label>
                            <input type="text" class="form-control" id ="estado" name ="estado" style="height: 35px" value="{{$proveedor->estado}}" disabled>
                        </div>  
                        <div class="col-12">
                            <label >País</label>
                            <input type="text" class="form-control" id ="pais" name ="pais" style="height: 35px" value="{{$proveedor->pais}}" disabled>
                        </div>
                        <div class="col-12">
                            <label >Télefono</label>
                            <input type="text" class="form-control" id ="telefono" name ="telefono" style="height: 35px" value="{{$proveedor->telefono}}" disabled>
                        </div>  
                        <div class="col-12">
                            <label >Email</label>
                            <input type="email" class="form-control" id ="email_proveedor" name ="email_proveedor" style="height: 35px" value="{{$proveedor->email_proveedor}}" disabled>
                        </div> 
                    </div>
                </div>
        </div>
    </div>
</div>