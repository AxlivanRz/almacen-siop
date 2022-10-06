@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Factura</h5>
          <div class="row">
            <!-- Personas con las que vive -->
            <div class="col-12">
                <form action="{{route('factura.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                    <input type="number" name="contador_producto" id="contador_producto" hidden >
                    <input type="number" name="encabezado_id" id="encabezado_id"  value="{{$encabezado->id_encabezado_factura}}" hidden >
                    <div id="relationship">
                        
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col-md-3">  
                        <label for="impfactura">Importe total IVA</label>
                        <input id="impfactura" type="number" class="form-control" id="impfactura" name="impfactura" step="any" required autofocus>
                    </div>
                    <div class="form-goup col-md-3">
                        <label for="total">Importe Total</label>
                        <input id="total" type="number" class="form-control" id = "total" name="total" step="any" required autofocus>
                    </div>
                </div>
            </div>
            <!-- /.Personas con las que vive -->
        </div>
        <div class="row py-2">
            <div class="margin">
                <div class="btn-group m-4">
                    <button type="submit" class="btn btn-success" id="agre_btn" style="display:none">
                        Agregar
                    </button>
                </div>
            </form>
                <div class="btn-group m-4">
                    <button type="button" class="btn btn-info" id="fin_btn" onClick="total();final();" style="display:block">
                        Finalizar
                    </button>
                </div>
                <div class="btn-group m-4">
                    <button type="button" class="btn btn-primary" id="agregar_btn" onClick="producto();cuentas();" style="display:block" >
                        <i class="fas fa-plus"></i> Agregar producto
                    </button>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger" onClick="delete_last()"id="btn_delete" style="display:none">
                        <i class="fas fa-minus-circle"></i> Eliminar el último producto
                    </button>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('scripts')
    <script>
        function load() {
            producto();
        }
        window.onload = load;

        var parent = 0;

        function producto() {
            parent++;
            if (parent > 1) {
                document.getElementById("btn_delete").style.display = "block";
            }
            var div = document.createElement("div");

            var header = document.createElement("h5");
            header.innerHTML = "Producto";
            header.className = "border-top mt-2";
            div.appendChild(header);

            var row = document.createElement("div");
            row.className = "row d-flex align-items-end";

            var column1 = document.createElement("div");
            column1.className = "col-3";
            row.appendChild(column1);
            var formGroup1 = document.createElement("div");
            formGroup1.className = "form-group";
            column1.appendChild(formGroup1);
            var label = document.createElement("label");
            label.innerHTML = "Articulo";
            formGroup1.appendChild(label);
            var select = document.createElement("select");
            select.className = "form-control";
            select.name = "articulokey[]";
            select.id = "artparent" + parent;
            select.required = "required";
            formGroup1.appendChild(select);
            $.ajax({ 
                type: "GET",
                url: "{{ route('articulo.get') }}",
                success: function(articulos) {
                    $.each(articulos, function(key, value) {
                        var option = document.createElement("option");
                        option.text = (value['nombre_articulo']) + " - " + (value['nombre_med']);
                        option.value = value['id_articulo'];
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
            cantidad.className = "form-control";
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
            label.innerHTML = "Base";
            formGroup2.appendChild(label);
            var base = document.createElement("input");
            base.className = "form-control";
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
            descuento.className = "form-control";
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
            iva.className = "form-control";
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
            label.innerHTML = "Impuesto Unitario";
            formGroup4.appendChild(label);
            var unitario = document.createElement("input");
            unitario.className = "form-control";
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
            label.innerHTML = "Precio";
            formGroup5.appendChild(label);
            var precio = document.createElement("input");
            precio.className = "form-control";
            precio.name = "preciokey[]";
            precio.id = "precio" + parent;
            precio.type = "number";
            precio.step = "any";
            precio.min = "0";
            precio.value = "0";
            formGroup5.appendChild(precio);

            div.appendChild(row);
            document.getElementById("relationship").appendChild(div);
            document.getElementById("contador_producto").value = parent;            
        }                    
        function delete_last() {
            parent--;
            var divElement = document.querySelector('#relationship');
            divElement.removeChild(divElement.lastElementChild);
            if (parent == 1) {
                document.getElementById("btn_delete").style.display = "none";
            }
            document.getElementById("contador_producto").value = parent;
        }
        function cuentas(){    
            var  i = 0;
           var contador = document.getElementById("contador_producto").value;
           if (parent == 1) {
                var descuento = document.getElementById('descuento' + contador).value;
                var cantidad = document.getElementById('cantidad' + contador).value;
                var base = document.getElementById('base' + contador).value;
                var iva = document.getElementById('iva' + contador).value;
                var unitario = (base/100) * iva;
                document.getElementById('unitario' + contador).value = unitario;
                var finalsuma1 = (Number(unitario) + Number(base)- Number(descuento));
                document.getElementById('precio' + contador).value = finalsuma1;
           }else{
                for ( i = 0; i <= contador; i++) {
                    var descuento = document.getElementById('descuento' + contador).value;
                    var cantidad = document.getElementById('cantidad' + contador).value;
                    var base = document.getElementById('base' + contador).value;
                    var iva = document.getElementById('iva' + contador).value;
                    var unitario = (base/100) * iva;
                    document.getElementById('unitario' + contador).value = unitario;
                    var finalsuma1 = (Number(unitario) + Number(base)) - Number(descuento);
                    document.getElementById('precio' + contador).value = finalsuma1;
                }
            }
        }
        function retroceso(){    
           var contador = document.getElementById("contador_producto").value;
            while (  contador != 0) {
                var descuento = document.getElementById('descuento' + contador).value;
                var cantidad = document.getElementById('cantidad' + contador).value;
                var base = document.getElementById('base' + contador).value;
                var iva = document.getElementById('iva' + contador).value;
                var unitario = (base/100) * iva;
                document.getElementById('unitario' + contador).value = unitario;
                var finalsuma1 = (Number(unitario) + Number(base) - Number(descuento));
                document.getElementById('precio' + contador).value = finalsuma1;
                contador--;
            }
        }
        function total() {
            var final = document.getElementById("contador_producto").value;
            while (  final != 0) {
                document.getElementById("btn_delete").style.display = "none";
                document.getElementById("agregar_btn").style.display = "none";
                document.getElementById("fin_btn").style.display = "none";
                document.getElementById("agre_btn").style.display = "block";
                final--;
            }
        }
        function final() {
            var cou = document.getElementById("contador_producto").value;
        
            var cantidad = Array.prototype.slice.call(document.getElementsByName('cantidadkey[]'));
            var valCant = cantidad.map((c) => c.value);

            var precio = Array.prototype.slice.call(document.getElementsByName('preciokey[]'));
            var valPrec = precio.map((p) => p.value);

            var unitario = Array.prototype.slice.call(document.getElementsByName('unitariokey[]'));
            var valUni = unitario.map((u) => u.value);

            let multiplicacion1 = new Array();
            let multiplicacion2 = new Array();
            
            for (z=0; z<valPrec.length; z++){
                for (w=0; w<valCant.length; w++){
                    multiplicacion1 [z]= valCant[z] * valPrec[z]; 
                }
            }
            for (a=0; a<valUni.length; a++){
                for (b=0; b<valCant.length; b++){
                    multiplicacion2 [a]= valCant[a] * valUni[a]; 
                }
            }
            // for ( i = 0; i < multiplicacion1.length; i++) {
            //     cuentaf [i]= multiplicacion1[i] + multiplicacion2[i]; 
            // }    
            
            let totalfinal = multiplicacion1.reduce((r, o) => r + o, 0);
            let totaliva = multiplicacion2.reduce((g, h) => g + h, 0);
            document.getElementById('impfactura').value = totaliva;
            document.getElementById('total').value = totalfinal;
        }
        setInterval(retroceso, 1000);
    </script>
@endsection
