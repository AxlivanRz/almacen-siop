@extends('sideb')
@section('content')
<div class="row my-5 py-2 ">
    <div class="col-3">
      <div class="card">
        <?php $contador = 0; ?>
        <div class="card-body">
            <h5 class="card-title">Vale</h5>
            <div class="row ">
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
                <?php $contador = 0; ?>
                <div class="card-body">
                <h5 class="card-title">Surtir Vale</h5>
                    <div class="row ">
                        <input type="number" id="contador_producto" hidden >
                        <div class="form-group" id="productoSurtir">
                        </div>
                    </div>
                    <div class="row border-top mt-2 d-flex justify-content-end">
                        <div class="form-group col-6">
                            <label >Total del vale</label>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control form-control-sm" id= "total" step="any" name="total" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row py-1 border-top mt-3" >
                        <div class="margin">
                            <div class="btn-group m-4">
                                <button type="button" class="btn btn-info" id="fin_btn" onClick="final();" style="display:block">
                                    Confirmar
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
                            <div class="btn-group m-4">
                                <button type="submit" class="btn btn-success" id="agre_btn" style="display:none">
                                    Agregar
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
@section('scriptSurtir')
    <script>
        function load() {
            producto();
        }
        window.onload = load;
        var contador = 0;
        function producto() {
            contador++;
            var producto = $('#productoSurtir');
            if (contador > 1) {
                document.getElementById("btn_delete").style.display = "block";
            }
           $(producto).append(
            '<div>'+
                '<div class="row d-flex align-items-end border-top mt-4">' +
                    '<div class="form-group col-3">' +
                        '<label>'+'Seleccionar Articulo'+'</label>' +
                        '<select class="articulo form-control form-control-sm" onChange= "getSelect(this)" name="entrada[]" id= "'+ contador +'">' +
                            '<option value="0">' +
                                'Selecione un articulo'  +
                            '</option>' +
                            '@foreach ($valeArticulos as $vArticulo)' +
                                '@foreach ( $entradas as $entrada)' +
                                    '@if ($vArticulo->id == $entrada->articulo_id)' +
                                    '<option value="{{$entrada->id}}">' +
                                        '{{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}} - {{$entrada->factura_id}}'  +
                                    '</option>' +
                                    '@endif' +
                                '@endforeach' +
                            '@endforeach' +
                        '</select>' +
                    '</div>' +
                    '<div class = "form-group col-9" id="datosFactura'+contador+'" >' +
                    '</div>'+
                '</div>'+
            '</div>'
            );
            document.getElementById("contador_producto").value = contador;
        }
        function delete_last() {
            contador--;
            var divElement = document.querySelector('#productoSurtir');
            divElement.removeChild(divElement.lastElementChild);
            if (contador == 1) {
                document.getElementById("btn_delete").style.display = "none";
            }
            document.getElementById("contador_producto").value = contador;
        }

        function final() {
            document.getElementById("btn_delete").style.display = "none";
            document.getElementById("agregar_btn").style.display = "none";
            document.getElementById("fin_btn").style.display = "none";
            document.getElementById("agre_btn").style.display = "block";
            var cou = document.getElementById("contador_producto").value;
        
            var cantidad = Array.prototype.slice.call(document.getElementsByName('cantidad[]'));
            var valCant = cantidad.map((c) => c.value);

            var precio = Array.prototype.slice.call(document.getElementsByName('precio[]'));
            var valPrec = precio.map((p) => p.value);

            let multiplicacion1 = new Array();
            
            for (z=0; z<valPrec.length; z++){
                for (w=0; w<valCant.length; w++){
                    multiplicacion1 [z]= valCant[z] * valPrec[z]; 
                }
            }
            let totalfinal = multiplicacion1.reduce((r, o) => r + o, 0);
            document.getElementById('total').value = totalfinal;
        }
        function getSelect(objSelect){
            var id = objSelect.id;
            var dato = document.getElementById('datosFactura' + id);
            var valor = objSelect.value;
            $.ajax({ 
                type: "GET",
                url: "/getFactura",
                data:{'id': valor}
            }).done(function(data){
                $.each(data, function(index, element){
                    $(dato).append(
                    '<div class="form-group row">'+
                        '<div class="form-group col-3">'+
                            '<label>' + 'Número de factura' + '</label>' +
                            '<input disabled type="number" class="form-control form-control-sm" value="'+element.factura_id+'" >' +
                        '</div>' +
                        '<div class="form-group col-3">'+
                            '<label>' + 'Precio' + '</label>' +
                            '<input disabled type="number" class="form-control form-control-sm" name="precio[]" step="any" id= "precio'+id+'" value="'+element.precio+'" >' +
                        '</div>' +
                        '<div class="form-group col-3">'+
                            '<label>' + 'Existencia' + '</label>' +
                            '<input disabled type="number" class="form-control form-control-sm" value="'+element.existencia+'" >' +
                        '</div>' +
                        '<div class="form-group col-3">' +
                            '<label>' + 'Cantidad' + '</label>' +
                            '<input type="number" class="form-control form-control-sm" name= "cantidad[]" id="cantidad'+id+'" value="0" min="0" max="'+element.existencia+'">' +
                        '</div>' +
                    '</div>'
                    );
                }); 
            });
            dato.removeChild(dato.lastElementChild);
        }   
    </script>
@endsection
