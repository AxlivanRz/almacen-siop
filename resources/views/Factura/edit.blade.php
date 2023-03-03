@extends('sideb')
@section('content')
@section('select2')
<script src="{{ asset('js/select2.min.js') }}" defer></script>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Factura</h5>
                <form action="{{route('factura.update',$factura->id_factura)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <?php $contador = 0;  ?>
                    <div id="eliminados" name="eliminados">
                    </div>
                    <div class="form-group row">
                        <div class="form-group col-3">
                            <label >Fecha</label>
                            <input type="date" class="form-control" id ="fecha" name ="fecha" data-inputmask-inputformat="dd/mm/yyyy" value="{{$factura->fecha}}">
                        </div>
                        <div class="form-group col-3">
                            <label >Número de factura</label>                
                            <input type="text" class="form-control"  id="numerof" name="numerof" value="{{$factura->numero_factura}}" readonly>
                        </div>
                        <div class="form-group col-3">
                            <label >Proveedor</label>                               
                            <select class="form-select"  name="proveedor" id="proveedor" >
                                @foreach ($proveedores as $proveedor )
                                    @if ($proveedor->id_proveedor == $factura->proveedor_id)  
                                        <option selected value="{{$proveedor->id_proveedor}}">
                                            {{$proveedor->nombre_empresa}}
                                        </option>
                                    @endif
                                @endforeach
                                @foreach ($proveedores as $proveedor)
                                    @if ($proveedor->id_proveedor != $factura->proveedor_id)
                                        <option value="{{$proveedor->id_proveedor}}">{{$proveedor->nombre_empresa}}</option>
                                    @endif   
                                @endforeach                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="number" name="contador_producto" id="contador_producto" hidden >
                        <div id="relationship" name="relationship">
                            @foreach ($entradas as $entrada)
                                @foreach ($articulos as $articulo)
                                    @if ($articulo->id == $entrada->articulo_id && $entrada->factura_id == $factura->numero_factura)
                                        <?php $contador++; ?>
                                        @if ($entrada->existencia != $entrada->cantidad)
                                            <div id="newpro" name= "newpro" class="newpro">
                                                <h5 class="border-top mt-4">Producto</h5>
                                                <div class="row d-flex align-items-end">
                                                    <div class="form-group col-5">
                                                        <input type="number" id="id_entrada{{$contador}}" name="id_entrada[]" value="{{$entrada->id}}" hidden>
                                                        <label>Articulo</label> 
                                                        <select class="form-control form-control-sm" name="articulokey[]" id="selectEdit{{$contador}}" disabled>
                                                            @if ($articulo->id == $entrada->articulo_id)  
                                                                <option selected value="{{$articulo->id}}">
                                                                    {{$articulo->nombre_articulo}} - {{$articulo->nombre_med}}
                                                                </option>
                                                            @endif
                                                            @foreach ($articulos as $articulo)
                                                                @if ($articulo->id != $entrada->articulo_id)
                                                                    <option value="{{$articulo->id}}">
                                                                        {{$articulo->nombre_articulo}} - {{$articulo->nombre_med}}
                                                                    </option>
                                                                @endif  
                                                            @endforeach     
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Cantidad</label>
                                                        <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad{{$contador}}" type="number" min="1" value = "{{$entrada->cantidad}}" disabled>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label> Precio Base</label>
                                                        <input class="form-control form-control-sm" name="basekey[]" id="base{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->base}}" disabled>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Descuento $</label>
                                                        <input class="form-control form-control-sm" name="descuentokey[]" id="descuento{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->descuento}}" disabled>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>IVA %</label>
                                                        <input class="form-control form-control-sm" name="iva" id="iva{{$contador}}" type="number" min="0" max="100" value = "{{$factura->iva}}" disabled>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Importe Unitario</label>
                                                        <input class="form-control form-control-sm" name="unitariokey[]" id="unitario{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->imp_unitario}}" disabled>
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Precio unitario</label>
                                                        <input class="form-control form-control-sm" name="preciokey[]" id="precio{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->precio}}" disabled>
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Existencia</label>
                                                        <input class="form-control form-control-sm" name="existencia[]" id="existencia{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->existencia}}" disabled>
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Caducidad</label>
                                                        <input class="form-control form-control-sm" name="caducidad[]" id="caducidad{{$contador}}" type="date" value = "{{$entrada->caducidad}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div id="newpro" name= "newpro" class="newpro">
                                                <h5 class="border-top mt-4">Producto</h5>
                                                <div class="row d-flex align-items-end">
                                                    <div class="form-group col-6">
                                                        <input type="number" id="id_entrada{{$contador}}" name="id_entrada[]" value="{{$entrada->id}}" hidden>
                                                        <label>Articulo</label> 
                                                        <select class="form-control form-control-sm" name="articulokey[]" id="selectEdit{{$contador}}">
                                                            @if ($articulo->id == $entrada->articulo_id)  
                                                                <option selected value="{{$articulo->id}}">
                                                                    {{$articulo->nombre_articulo}} - {{$articulo->nombre_med}}
                                                                </option>
                                                            @endif
                                                            @foreach ($articulos as $articulo)
                                                                @if ($articulo->id != $entrada->articulo_id)
                                                                    <option value="{{$articulo->id}}">
                                                                        {{$articulo->nombre_articulo}} - {{$articulo->nombre_med}}
                                                                    </option>
                                                                @endif  
                                                            @endforeach     
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Cantidad</label>
                                                        <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad{{$contador}}" type="number" min="0" value = "{{$entrada->cantidad}}">
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label> Precio</label>
                                                        <input class="form-control form-control-sm" name="basekey[]" id="base{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->base}}">
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Descuento $</label>
                                                        <input class="form-control form-control-sm" name="descuentokey[]" id="descuento{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->descuento}}">
                                                    </div>
                                                    <div class="form-group col-1">
                                                        <label>IVA %</label>
                                                        <input class="form-control form-control-sm" name="iva" id="iva{{$contador}}" type="number" min="0" max="100" value = "{{$factura->iva}}">
                                                    </div>
                                                    <div class="form-group col-2">
                                                        <label>Importe IVA</label>
                                                        <input class="form-control form-control-sm" name="unitariokey[]" id="unitario{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->imp_unitario}}">
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Precio unitario</label>
                                                        <input class="form-control form-control-sm" name="preciokey[]" id="precio{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->precio}}">
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Precio total</label>
                                                        <input class="form-control form-control-sm" name="preciototalkey[]" id="preciototal{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->preciofinal}}">
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Existencia</label>
                                                        <input class="form-control form-control-sm" name="existencia[]" id="existencia{{$contador}}" type="number" step="any" min="0" value = "{{$entrada->existencia}}" disabled>
                                                    </div>
                                                    <div class="form-grop col-2">
                                                        <label>Caducidad</label>
                                                        <input class="form-control form-control-sm" name="caducidad[]" id="caducidad{{$contador}}" type="date" value = "{{$entrada->caducidad}}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group row border-top mt-3">
                        <h5 class="card-title">Total Factura</h5>
                        @if (isset($factura->respaldo_factura))
                            <div class="form-group col-2 d-flex  align-items-end" >
                                <label for="archivo" class="col-form-label">
                                    <i class="fas fa-check-circle" style = "color: rgb(0, 215, 0);"></i>
                                    Archivo existente
                                    <a target="_blank" href="{{asset('storage').'/'.$factura->respaldo_factura}}">archivo</a>
                                </label>
                            </div>
                        @else
                            <div class="form-group col-2 d-flex  align-items-end" >
                                <label for="archivo" class="col-form-label">
                                    <i class="fas fa-times-circle" style = "color: red;"></i>
                                    Sin archivo
                                </label>
                            </div>
                        @endif
                        <input type="text" value="{{$contador}}" id= "contador_edit" hidden>
                        <div class="form-group col-3">
                            <label >Respaldo de factura</label>
                            <input class="form-control form-control-sm" id="archivo" name="archivo" type="file">
                        </div>
                        <div class="form-group col-3">
                            <label for="impfactura">Importe total IVA</label>
                            <input id="impfactura" type="number" class="form-control form-control-sm" id="impfactura" name="impfactura" value="{{$factura->imp_iva}}" step="any" readonly>
                        </div>
                        <div class="form-group col-2">                                          
                            <label>Origen del Recurso</label>                               
                            <select class="form-select form-select-sm"  name="recurso" id="recurso" >
                                @foreach ($origenes as $origen )
                                    @if ($factura->recurso_id == $origen->id_origen)
                                    <option selected value="{{$origen->id_origen}}">
                                        {{$origen->nombre_recurso}}
                                    </option>
                                    @endif   
                                @endforeach  
                                @foreach ($origenes as $origen )
                                    @if ($factura->recurso_id != $origen->id_origen)
                                    <option value="{{$origen->id_origen}}">
                                        {{$origen->nombre_recurso}}
                                    </option>
                                    @endif   
                                @endforeach                 
                            </select>
                        </div>  
                        <div class="form-goup col-2">
                            <label for="total">SubTotal</label>
                            <input id="subtotal" type="number" class="form-control form-control-sm" id = "subtotal" name="subtotal" step="any" value="{{$factura->subtotal}}" readonly>
                        </div>
                        <div class="form-group col-2">
                            <label for="total">Importe Total</label>
                            <input type="number" class="form-control form-control-sm" id = "total" name="total" step="any" value="{{$factura->imp_total}}" readonly>
                        </div>
                        
                    </div>
                    <div class= "row py-2">
                        <div class="margin">
                            <div class="btn-group m-4">
                                <button type="submit" class="btn btn-primary" id="agre_btn" style="display:none">
                                    Editar
                                </button>
                            </div>
                            <div class="btn-group m-4">
                                <button type="button" class="btn btn-info" id="fin_btn" onClick="final();" style="display:block">
                                    Finalizar
                                </button>
                            </div>
                            <div class="btn-group m-4">
                                <button type="button" class="btn btn-primary" id="agregar_btn" onClick="producto();addSelect2();" style="display:block" >
                                    <i class="fas fa-plus"></i> Agregar producto
                                </button>
                            </div> 
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" onClick="get_delete();delete_last();"id="btn_delete" style="display:none">
                                    <i class="fas fa-minus-circle"></i> Eliminar el último producto
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        function load() {
            contadoredit();
            
        }
        var increment = 0;
        var parent = 0;
        window.onload = load;
        function contadoredit(){
            var valoredit = document.getElementById("contador_edit").value;
            parent = Number(valoredit);
            document.getElementById("contador_producto").value = parent; 
            if (parent > 1) {
                document.getElementById("btn_delete").style.display = "block";
            }
            for (let index = 0; index <= Number(valoredit); index++) {
                $("#selectEdit" +index).select2();
            }
        }

        function addSelect2(){
            $("#select" +parent).select2();
        }

        function producto() {
            parent++;
            if (parent > 1) {
                document.getElementById("btn_delete").style.display = "block";
            }
            var div = document.createElement("div");
            div.id = "newpro";
            div.className = "newpro";
            div.name = "newppro";

            var header = document.createElement("h5");
            header.innerHTML = "Producto";
            header.className = "border-top mt-2";
            div.appendChild(header);

            var row = document.createElement("div");
            row.className = "row d-flex align-items-end";

            var column1 = document.createElement("div");
            column1.className = "col-6";
            row.appendChild(column1);
            var formGroup1 = document.createElement("div");
            formGroup1.className = "form-group";
            column1.appendChild(formGroup1);
            var label = document.createElement("label");
            label.innerHTML = "Articulo";
            formGroup1.appendChild(label);
            var select = document.createElement("select");
            select.className = "form-control form-control-sm";
            select.name = "articulokey[]";
            select.id = "select" + parent;
            select.required = "required";
            formGroup1.appendChild(select);
            $.ajax({ 
                type: "GET",
                url: "{{ route('articulo.get') }}",
                success: function(articulos) {
                    $.each(articulos, function(key, value) {
                        var option = document.createElement("option");
                        option.text = (value['nombre_articulo']) + " - " + (value['nombre_med']);
                        option.value = value['id'];
                        select.add(option);
                        formGroup1.appendChild(select);
                    })
                }
            });
            var column3 = document.createElement("div");
            column3.className = "col-2";
            row.appendChild(column3);
            var label = document.createElement("label");
            label.innerHTML = "Cantidad";
            column3.appendChild(label);
            var cantidad = document.createElement("input");
            cantidad.className = "form-control form-control-sm";
            cantidad.name = "cantidadkey[]";
            cantidad.id = "cantidad" + parent;
            cantidad.type = "number";
            cantidad.min = "0";
            cantidad.value = "0";
            
            column3.appendChild(cantidad);

            var column3 = document.createElement("div");
            column3.className = "col-2";
            row.appendChild(column3);
            var formGroup2 = document.createElement("div");
            formGroup2.className = "form-group";
            column3.appendChild(formGroup2);
            var label = document.createElement("label");
            label.innerHTML = "Precio Base";
            formGroup2.appendChild(label);
            var base = document.createElement("input");
            base.className = "form-control form-control-sm";
            base.name = "basekey[]";
            base.id = "base" + parent;
            base.type = "number";
            base.step = "any";
            base.min = "0";
            base.value = "0";
            formGroup2.appendChild(base);

            var column4 = document.createElement("div");
            column4.className = "col-2";
            row.appendChild(column4);
            var formGroup2 = document.createElement("div");
            formGroup2.className = "form-group";
            column4.appendChild(formGroup2);
            var label = document.createElement("label");
            label.innerHTML = "Descuento";
            formGroup2.appendChild(label);
            var descuento = document.createElement("input");
            descuento.className = "form-control form-control-sm";
            descuento.name = "descuentokey[]";
            descuento.id = "descuento" + parent;
            descuento.type = "number";
            descuento.step = "any";
            descuento.min = "0";
            descuento.value = "0";
            formGroup2.appendChild(descuento);

            var column5 = document.createElement("div");
            column5.className = "col-1";
            row.appendChild(column5);
            var formGroup3 = document.createElement("div");
            formGroup3.className = "form-group";
            column5.appendChild(formGroup3);
            var label = document.createElement("label");
            label.innerHTML = "IVA %";
            formGroup3.appendChild(label);
            var iva = document.createElement("input");
            iva.className = "form-control form-control-sm";
            iva.name = "iva";
            iva.id = "iva" + parent;
            iva.type = "number";
            iva.min = "0";
            iva.value = "16";
            iva.max = "100";
            formGroup3.appendChild(iva);

            var column6 = document.createElement("div");
            column6.className = "col-2";
            row.appendChild(column6);
            var formGroup4 = document.createElement("div");
            formGroup4.className = "form-group";
            column6.appendChild(formGroup4);
            var label = document.createElement("label");
            label.innerHTML = "Importe IVA";
            formGroup4.appendChild(label);
            var unitario = document.createElement("input");
            unitario.className = "form-control form-control-sm";
            unitario.name = "unitariokey[]";
            unitario.id = "unitario" + parent;
            unitario.type = "number";
            unitario.step = "any";
            unitario.min = "0";
            unitario.value = "0";
            formGroup4.appendChild(unitario);

            var column7 = document.createElement("div");
            column7.className = "col-2";
            row.appendChild(column7);
            var formGroup5 = document.createElement("div");
            formGroup5.className = "form-group";
            column7.appendChild(formGroup5);
            var label = document.createElement("label");
            label.innerHTML = "Precio Unitario";
            formGroup5.appendChild(label);
            var precio = document.createElement("input");
            precio.className = "form-control form-control-sm";
            precio.name = "preciokey[]";
            precio.id = "precio" + parent;
            precio.type = "number";
            precio.step = "any";
            precio.min = "0";
            precio.value = "0";
            formGroup5.appendChild(precio);

            var column8 = document.createElement("div");
            column8.className = "col-2";
            row.appendChild(column8);
            var formGroup6 = document.createElement("div");
            formGroup6.className = "form-group";
            column8.appendChild(formGroup6);
            var label = document.createElement("label");
            label.innerHTML = "Precio Total";
            formGroup6.appendChild(label);
            var precioT = document.createElement("input");
            precioT.className = "form-control form-control-sm";
            precioT.name = "preciototalkey[]";
            precioT.id = "preciototal" + parent;
            precioT.type = "number";
            precioT.step = "any";
            precioT.min = "0";
            precioT.value = "0";
            formGroup6.appendChild(precioT);

            var column9 = document.createElement("div");
            column9.className = "col-2";
            row.appendChild(column9);
            var formGroup7 = document.createElement("div");
            formGroup7.className = "form-group";
            column9.appendChild(formGroup7);
            var label = document.createElement("label");
            label.innerHTML = "Caducidad";
            formGroup7.appendChild(label);
            var caducidad = document.createElement("input");
            caducidad.className = "form-control form-control-sm";
            caducidad.name = "caducidad[]";
            caducidad.id = "caducidad" + parent;
            caducidad.type = "date";
            formGroup7.appendChild(caducidad);

            div.appendChild(row);
            document.getElementById("relationship").appendChild(div);
            document.getElementById("contador_producto").value = parent;            
        }        
        var incrementC = 0;
        function get_delete() {
            var valoredit = document.getElementById("contador_edit").value; 
            if ( parent <= valoredit) {
                var bandera = document.getElementById('id_entrada' + parent).value;
                incrementC++;
                var eliminado = document.createElement("input");
                eliminado.name = "elimado[]";
                eliminado.id = "eliminado" + incrementC;
                eliminado.type = "number";
                eliminado.min = "0";
                eliminado.hidden = "true";
                document.getElementById("eliminados").appendChild(eliminado);
                var hola = document.getElementById('eliminado' + incrementC).value = bandera;
                valoredit--; 
                document.getElementById("contador_edit").value = valoredit;
                console.log(hola);
            }
        }
        function delete_last() {
            if (parent > 1) {  
                $(".newpro").last().remove();
            }
            parent--;
            if (parent == 1) {
                document.getElementById("btn_delete").style.display = "none";
            }
            document.getElementById("contador_producto").value = parent;  
        }
        function retroceso(){    
            var contador = document.getElementById("contador_producto").value;
            while (  contador != 0) {
                var descuento = document.getElementById('descuento' + contador).value;
                var cantidad = document.getElementById('cantidad' + contador).value;
                var base = document.getElementById('base' + contador).value;
                var iva = document.getElementById('iva' + contador).value;
                var unitario = (base-descuento)/100 * iva;

                document.getElementById('unitario' + contador).value = unitario;

                var finalsuma1 = (Number(unitario) + Number(base) - Number(descuento))/Number(cantidad);

                document.getElementById('precio' + contador).value = finalsuma1;

                var preciototal = document.getElementById('preciototal' + contador);
                preciototal.value = (Number(base) + Number(unitario) - Number(descuento));
                contador--;
            }
        }
        function final() {
            document.getElementById("btn_delete").style.display = "none";
            document.getElementById("agregar_btn").style.display = "none";
            document.getElementById("fin_btn").style.display = "none";
            document.getElementById("agre_btn").style.display = "block";
        
            var cou = document.getElementById("contador_producto").value;
            var base = Array.prototype.slice.call(document.getElementsByName('basekey[]'));
            var valBase = base.map((b) => b.value);
            // var cantidad = Array.prototype.slice.call(document.getElementsByName('cantidadkey[]'));
            // var valCant = cantidad.map((c) => c.value);
            // var precio = Array.prototype.slice.call(document.getElementsByName('preciokey[]'));
            // var valPrec = precio.map((p) => p.value);
            var unitario = Array.prototype.slice.call(document.getElementsByName('unitariokey[]'));
            var valUni = unitario.map((u) => u.value);
            var descuento = Array.prototype.slice.call(document.getElementsByName('descuentokey[]'));
            var valDescuento = descuento.map((a) => a.value);
            // let multiplicacion1 = new Array();
            // let multiplicacion2 = new Array();
            // let multiplicacion3 = new Array();
            // for (z=0; z<valPrec.length; z++){
            //     for (w=0; w<valCant.length; w++){
            //         multiplicacion1 [z]= valCant[z] * valPrec[z]; 
            //     }
            // }
            // for (a=0; a<valUni.length; a++){
            //     for (d=0; d<valCant.length; d++){
            //         multiplicacion2 [a]= valCant[a] * valUni[a]; 
            //     }
            // }
            // for ( i = 0; i < multiplicacion1.length; i++) {
            //     cuentaf [i]= multiplicacion1[i] + multiplicacion2[i]; 
            // }    
            let totaliva = valUni.reduce((g, h) => Number(g) + Number(h), 0);
            let subtotal =  valBase.reduce((r, t) => Number(r) + Number(t), 0);
            let total_descuento = valDescuento.reduce((f,i) => Number(f) + Number(i), 0);
            let totalfinal = totaliva + subtotal;
            let totalfinal1 = totalfinal - total_descuento;
            document.getElementById('impfactura').value = totaliva;
            document.getElementById('subtotal').value = subtotal;
            document.getElementById('total').value = totalfinal1;
        }
        setInterval(retroceso, 1000);
    </script>
@endsection
