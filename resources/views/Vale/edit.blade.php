@extends('sideb')
@section('content')
@section('select2')
<script src="{{ asset('js/select2.min.js') }}" defer></script>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
<div class="row my-5 py-2 ">
    <div class="col-2"></div>
    <div class="col-8">
      <div class="card">
        <form action="{{route('vale.update',$vale->id)}}" method="post">
            @csrf
            @method('PUT')
            <?php $contador = 0; ?>
            <div class="card-body">
            <h5 class="card-title">Editar Vale</h5>
                <div class="row ">
                    <input type="number" id="contador_producto" hidden>
                    <div class="form-group" id="producto">
                        @foreach ($valeArticulos as $vArticulo)
                            <?php $contador++;?>
                            <div id="newpro" name= "newpro" class="newpro">
                                <div class="row d-flex align-items-end"> 
                                    <div class="form-group col-8">
                                        <label>Articulo</label> 
                                        <select class="form-control form-control-sm" name="articulokey[]" id="selectEdit{{$contador}}">                                               
                                            <option value="{{$vArticulo->id}}">
                                                {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                            </option>                                           
                                            @foreach ($dif2 as $articulo1)
                                                @if ($articulo1->id != $vArticulo->id)
                                                    <option value="{{$articulo1->id}}">
                                                        {{$articulo1->nombre_articulo}} - {{$articulo1->nombre_med}}
                                                    </option> 
                                                @endif
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Cantidad</label>
                                        <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad{{$contador}}" type="number" min="0" value = "{{$vArticulo->pivot->cantidad}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row py-2 border-top mt-3" >
                    <div class="margin">
                        <input type="text" value="{{$contador}}" id= "contador_edit" hidden>
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
                            <button type="button" class="btn btn-primary" id="agregar_btn" onClick="producto();addSelect2();" style="display:block">
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
        </form>
      </div>
    </div>
</div>
@endsection
@section('editarVale')
    <script>
        function load() {
            contadoredit();
        }
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
            $("#artparent" +parent).select2();
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

            var row = document.createElement("div");
            row.className = "row d-flex align-items-end";

            var column1 = document.createElement("div");
            column1.className = "col-8";
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
            select.id = "artparent" + parent;
            select.required = "required";
            formGroup1.appendChild(select);
            $.ajax({ 
                type: "GET",
                url: "{{ route('articulo.existencia') }}",
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
            column3.className = "col-4";
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

            div.appendChild(row);
            document.getElementById("producto").appendChild(div);
            document.getElementById("contador_producto").value = parent;  
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
        function final() {
            document.getElementById("btn_delete").style.display = "none";
            document.getElementById("agregar_btn").style.display = "none";
            document.getElementById("fin_btn").style.display = "none";
            document.getElementById("agre_btn").style.display = "block";
        }
    </script>
@endsection
