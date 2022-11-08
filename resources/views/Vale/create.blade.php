@extends('sideb')
@section('content')
<div class="row my-5 py-2 ">
    <div class="col-2"></div>
    <div class="col-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Crear Vale</h5>
            <div class="row ">
                <input type="number" id="contador_producto" hidden>
                <div class="form-group" id="producto">
                </div>
            </div>
            <div class="row py-2 border-top mt-3" >
                <div class="margin">
                    <div class="btn-group m-4">
                        <button type="submit" class="btn btn-success" id="agre_btn" style="display:none">
                            Agregar
                        </button>
                    </div>
                    <div class="btn-group m-4">
                        <button type="button" class="btn btn-info" id="fin_btn" onClick="final();" style="display:block">
                            Finalizar
                        </button>
                    </div>
                    <div class="btn-group ">
                        <button type="button" class="btn btn-primary" id="agregar_btn" onClick="producto();" style="display:block">
                            <i class="fas fa-plus"></i> Agregar producto
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger" id="btn_delete" onClick="delete_last()" style="display:block">
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
@section('scriptsApi')
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
            header.className = "border-top mt-2 py-2";
            div.appendChild(header);

            var row = document.createElement("div");
            row.className = "row d-flex align-items-end";

            var column1 = document.createElement("div");
            column1.className = "col-5";
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
            column3.className = "col-5";
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

            div.appendChild(row);
            document.getElementById("producto").appendChild(div);
            document.getElementById("contador_producto").value = parent;            
        }                    
        function delete_last() {
            parent--;
            var divElement = document.querySelector('#producto');
            divElement.removeChild(divElement.lastElementChild);
            if (parent == 1) {
                document.getElementById("btn_delete").style.display = "none";
            }
            document.getElementById("contador_producto").value = parent;
        }
        
        function final() {
            document.getElementById("btn_delete").style.display = "none";
            document.getElementById("agregar_btn").style.display = "none";
            document.getElementById("fin_btn").style.display = "none";
            document.getElementById("agre_btn").style.display = "block";
        }
        setInterval(retroceso, 1000);
    </script>