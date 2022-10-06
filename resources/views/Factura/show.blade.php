<div class="modal fade" id="facturaShow{{$encabezado->id_encabezado_factura}}" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="encabezadoShowLabel" aria-hidden="true">
    <div class=" modal-dialog modal-sm ">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " >
                <h5 class="modal-title" id="encabezadoEditLabel" >Datos factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="content" style="align-self: center">
                    <div class="modal-body">
                        <div class="col-12">  
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control"  id="fecha" name="fecha" style="height: 35px" value="{{$encabezado->fecha}}" disabled>
                        </div>
                        <div class="col-12">
                            <label for="numerof">Número factura</label>
                            <input type="text" class="form-control"  id="numerof" name="numerof" style="height: 35px" value="{{$encabezado->numero_factura}}" disabled>
                        </div>
                        <div class="col-12">
                            <label for="folio" >Folio</label>
                            <input type="text" class="form-control" id ="folio" name ="folio" style="height: 35px" value="{{$encabezado->folio}}" disabled>
                        </div>
                        <div class="col-12">  
                            <label >Proveedor</label>                               
                            <select class="form-select form-select-sm"  name="proveedor" id="proveedor" disabled>
                                @foreach ($proveedores as $proveedor )
                                    @if ($proveedor->id_proveedor == $encabezado->proveedor_id)  
                                        <option selected value="{{$proveedor->id_proveedor}}">
                                            {{$proveedor->nombre_empresa}}
                                        </option>
                                    @endif
                                @endforeach                   
                            </select>
                        </div>
                        @foreach ( $facturas as $factura )
                            @if ($factura->encabezado_id == $encabezado->id_encabezado_factura)
                                <div class="col-12">  
                                    <label for="total_iva">IVA</label>
                                    <input type="text" class="form-control"  name="total_iva" style="height: 35px" value="{{$factura->iva}}" disabled>
                                </div>
                                <div class="col-12">
                                    <label for="numerof">Importe total IVA</label>
                                    <input type="text" class="form-control"  id="numerof" name="numerof" style="height: 35px" value="{{$factura->imp_iva}}" disabled>
                                </div>
                                <div class="col-12">
                                    <label for="segundo_Apellido" >Importe total</label>
                                    <input type="text" class="form-control" id ="folio" name ="folio" style="height: 35px" value="{{$factura->imp_total}}" disabled>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
        </div>
    </div>
</div>