@extends('sideb')
@section('content')
<div class="row my-5 py-2 ">
    <div class="col-3">
      <div class="card">
        <?php $contador = 0; ?>
        <div class="card-body">
            <h5 class="card-title">Vale</h5>
            <div class="row ">
                <input type="number" id="contador_producto" hidden>
                <div class="form-group" id="producto">
                    @foreach ($valeArticulos as $vArticulo)
                        <?php $contador++;?>
                        <div id="newpro" name= "newpro" class="newpro">
                            <h5 class="border-top mt-4">Producto</h5>
                            <div class="row d-flex align-items-end"> 
                                <div class="form-group col-8">
                                    @if ($vale->articulos->isNotEmpty())
                                        @if ($valeArticulos !=null)
                                            <label>Articulo</label> 
                                            <select class="form-control form-control-sm" name="articulokey[]" id="artparent{{$contador}}" disabled>                                                    
                                                <option selected value="{{$vArticulo->id}}">
                                                    {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                                </option>                                                   
                                                @foreach ($articulos as $articulo)
                                                    @if ($articulo->id != $vArticulo->id)
                                                        <option value="{{$articulo->id}}">
                                                            {{$articulo->nombre_articulo}} - {{$articulo->nombre_med}}
                                                        </option>
                                                    @endif  
                                                @endforeach     
                                            </select>
                                        @endif
                                    @endif
                                </div>
                                <div class="form-group col-4">
                                    <label>Cantidad</label>
                                    <input class="form-control form-control-sm" name="cantidadkey[]" id="cantidad{{$contador}}" type="number" min="0" value = "{{$vArticulo->pivot->cantidad}}" disabled>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>
    {{-- Para surtir --}}
    {{-- Para surtir --}}
    <div class="col-9">
        <div class="card">
            <form action="{{route('surtir.storeVale',$vale->id)}}" method="post">
                @csrf
                @method('PUT')
                <?php $contador = 0; ?>
                <div class="card-body">
                <h5 class="card-title">Surtir Vale</h5>
                    <div class="row ">
                        <input type="number" id="contador_producto" hidden>
                        <div class="form-group" id="producto">
                            @foreach ($valeArticulos as $vArticulo)
                                <?php $contador++;?>
                                <div id="newpro" name= "newpro" class="newpro">
                                    <h5 class="border-top mt-4">Producto</h5>
                                    <div class="row d-flex align-items-end">                                         
                                       
                                           
                                                <div class="form-group col-3">
                                                    <label>Seleccionar Articulo</label> 
                                                    <select class="form-control form-control-sm" name="articulokey[]" >
                                                        @foreach ( $entradas as $entrada)
                                                        @if ($vArticulo->id == $entrada->articulo_id)
                                                        <option value="{{$entrada->id}}">
                                                            {{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}
                                                        </option> 
                                                        @endif 
                                                        @endforeach                                                                                                                                                     
                                                    </select>
                                                </div>
                                                {{-- <div class="form-group col-2">
                                                    <label>Número de factura</label>
                                                    <input type="number" class="form-control form-control-sm" value="{{$entrada->factura_id}}" disabled>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label>Precio</label>
                                                    <input type="number" class="form-control form-control-sm" value="{{$entrada->precio}}" disabled>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label>Existencia</label>
                                                    <input type="number" class="form-control form-control-sm" value="{{$entrada->existencia}}" disabled>
                                                </div>
                                                <div class="form-group col-2">
                                                    <label>Cantidad</label>
                                                    <input type="number" class="form-control form-control-sm" value="0" min="0" max="{{$entrada->existencia}}">
                                                </div> --}}
                                                   
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row py-1 border-top mt-3" >
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
</div>
@endsection
@section('editarSurtir')
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
