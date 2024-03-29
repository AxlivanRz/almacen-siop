@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Factura</h5>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <label >Fecha</label>
                        <input type="date" class="form-control" id ="fecha" name ="fecha" data-inputmask-inputformat="dd/mm/yyyy" value="{{$factura->fecha}}" disabled>
                    </div>
                    <div class="col-3">
                        <label >Número de factura</label>                
                        <input type="text" class="form-control"  id="numerof" name="numerof" value="{{$factura->numero_factura}}" disabled>
                    </div>
                    <div class="col-3">
                        <label >Folio</label>
                        <input type="text" class="form-control " id ="folio" name ="folio" value="{{$factura->id_factura}}" disabled>
                    </div>
                    <div class="col-3">
                        <label >Proveedor</label>                               
                        <select class="form-select"  name="proveedor" id="proveedor" disabled>
                            @foreach ($proveedores as $proveedor )
                                @if ($proveedor->id_proveedor == $factura->proveedor_id)  
                                    <option selected value="{{$proveedor->id_proveedor}}">
                                        {{$proveedor->nombre_empresa}}
                                    </option>
                                @endif
                            @endforeach         
                        </select>
                    </div>
                </div>
                @foreach ($entradas as $entrada)
                    @foreach ($articulos as $articulo)
                        @if ($articulo->id == $entrada->articulo_id && $entrada->factura_id == $factura->numero_factura)
                            <h5 class="border-top mt-4">Producto</h5>
                            <div class="row d-flex align-items-end">
                                <div class="form-group col-5">
                                    <label>Articulo</label> 
                                    <select class="form-control form-control-sm" name="articulokey[]" id="artparent" disabled>
                                        @if ($articulo->id == $entrada->articulo_id)  
                                            <option selected value="{{$articulo->id}}">
                                                {{$articulo->nombre_articulo}}-{{$articulo->nombre_med}}
                                            </option>
                                        @endif   
                                    </select>
                                </div>
                                <div class="form-group col-2">
                                    <label>Cantidad</label>
                                    <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad" type="number" min="0" value = "{{$entrada->cantidad}}" disabled>
                                </div>
                                <div class="form-group col-3">
                                    <label>Precio Base</label>
                                    <input class="form-control form-control-sm" name="basekey[]" id="base" type="number" step="any" min="0" value = "{{$entrada->base}}" disabled>
                                </div>
                                <div class="form-group col-2">
                                    <label>Descuento $</label>
                                    <input class="form-control form-control-sm" name="descuentokey[]" id="descuento" type="number" step="any" min="0" value = "{{$entrada->descuento}}" disabled>
                                </div>
                                <div class="form-group col-2">
                                    <label>IVA %</label>
                                    <input class="form-control form-control-sm" name="iva" id="iva" type="number" min="0" max="100" value = "{{$entrada->iva}}" disabled>
                                </div>
                                <div class="form-group col-3">
                                    <label>Importe IVA</label>
                                    <input class="form-control form-control-sm" name="unitariokey[]" id="unitario" type="number" step="any" min="0" value = "{{$entrada->imp_unitario}}" disabled>
                                </div>
                                <div class="form-grop col-2">
                                    <label>Precio unitario</label>
                                    <input class="form-control form-control-sm" name="preciokey[]" id="precio" type="number" step="any" min="0" value = "{{$entrada->precio}}" disabled>
                                </div>
                                <div class="form-grop col-2">
                                    <label>Existencia</label>
                                    <input class="form-control form-control-sm" name="existencia[]" id="existencia" type="number" step="any" min="0" value = "{{$entrada->existencia}}" disabled>
                                </div>
                                <div class="form-grop col-2">
                                    <label>Caducidad</label>
                                    <input class="form-control form-control-sm" type="date" name="caducidad[]" id="caducidad" value = "{{$entrada->caducidad}}" disabled>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
                <div class="row border-top mt-3 py-2">
                    <h5 class="card-title">Total Factura</h5>
                    @if (isset($factura->respaldo_factura))
                        <div class="col-2 d-flex  align-items-end" >
                            <label for="archivo" class="col-form-label">
                                <i class="fas fa-check-circle" style = "color: rgb(0, 215, 0);"></i>
                                Archivo existente
                            </label>
                            <a target="_blank" href="{{asset('storage').'/'.$factura->respaldo_factura}}">Archivo</a>
                        </div>
                    @else
                        <div class="col-2 d-flex  align-items-end" >
                            <label for="archivo" class="col-form-label">
                                <i class="fas fa-times-circle" style = "color: red;"></i>
                                Sin archivo
                            </label>
                        </div>
                    @endif
                    <div class="form-group col-3">                                          
                        <label>Origen del Recurso</label>                               
                        <select class="form-select form-select-sm"  disabled name="recurso" id="recurso" >
                            @foreach ($origenes as $origen )
                                @if ($factura->recurso_id == $origen->id_origen)
                                <option selected value="{{$origen->id_origen}}">
                                    {{$origen->nombre_recurso}}
                                </option>
                                @endif   
                            @endforeach                
                        </select>
                    </div>  
                    <div class="col-3">
                        <label for="impfactura">Importe total IVA</label>
                        <input id="impfactura" type="number" class="form-control form-select-sm" id="impfactura" name="impfactura" value="{{$factura->imp_iva}}" step="any" disabled>
                    </div>
                    <div class="form-goup col-2">
                        <label for="total">SubTotal</label>
                        <input id="subtotal" type="number" class="form-control form-control-sm" id = "subtotal" name="subtotal" step="any" value="{{$factura->subtotal}}" disabled>
                    </div>
                    <div class="col-2">
                        <label for="total">Importe Total</label>
                        <input id="total" type="number" class="form-control form-select-sm" id = "total" name="total" step="any" value="{{$factura->imp_total}}" disabled >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

  