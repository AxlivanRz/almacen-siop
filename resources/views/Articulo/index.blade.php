@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-cubes fa-2x"></i> &NonBreakingSpace; Articulos</h5>
    </div>
    <div class="col-7 d-md-flex justify-content-end my-3">
        <div class="col-7">
            <input class="form-control form-control-sm border border-primary border-2" type="text" placeholder="Ingrese el texto a buscar" name="search_aj" id="search_aj" onkeyup="search()">
       </div>        
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-12">
    <div class="table-responsive">
        <table class="table" id="tbl_ajx_art">
            <thead>
            <tr>
                <th scope="col">Clave</th>
                <th scope="col">Nombre</th>
                <th scope="col">Unidad de medida</th>
                <th scope="col">Partida</th>
                <th scope="col" style="width: 150px;">
                    Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </th>     
                <th scope="col-1">
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#articuloCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>          
            </tr>
            </thead>
            <tbody id="delete">            
                @if ($articulos->isNotEmpty())
                    @foreach ( $articulos as $articulo )
                        <tr>
                            <td scope="row"><strong>{{$articulo->clave_articulo}}</strong></td>
                            <td>{{$articulo->nombre_articulo}}</td>
                            <td>{{$articulo->nombre_med}}</td> 
                            @foreach ($partidas as $partida )
                                @if ($partida->id_partida == $articulo->partida_id)  
                                <td>{{$partida->nombre_partida}}</td>                              
                                @else
                                    @if ($articulo->partida_id == null)
                                        <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                                    @endif
                                @endif
                            @endforeach                                                
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#articuloEdit{{$articulo->id}}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#articuloShow{{$articulo->id}}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>       
                            <td></td>
                        </tr>                    
                    @endforeach
                @else
                    <td colspan="6" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
        <div class = "d-flex">{{$articulos->links()}}</div>
    </div>
    @if ($articulos->isNotEmpty())  
        @foreach ($articulos as $articulo )
            @include('Articulo.edit')   
            @include('Articulo.show')   
        @endforeach
    @endif
    @include('Articulo.create') 
    @if ($errors->isNotEmpty())
        @foreach ( $errors->all() as $nuevo )
        <script>
            toastr.error('{{$nuevo}}');
        </script>
        @endforeach
    @endif
    @if(Session::has('exito'))
    <script>
        toastr.success("{!! Session::get('exito') !!}");
    </script>
    @endif
    @if(Session::has('no'))
    <script>
        toastr.error("{!! Session::get('no') !!}");
    </script>
    @endif  
</div>
@endsection
@section('search_art')
<script>
function search(){
    var busqueda = document.getElementById('search_aj').value.toLowerCase();
    var dato = document.getElementById('delete');
    var tabla = document.getElementById('tbl_ajx_art'); 
    $.ajax({ 
        type: "GET",
        url: "/resultArt",
        data:{'busqueda': busqueda,
        }
    }).done(function(data){
        console.log(busqueda);//quitarc
        $.each(data, function(index, element){
            $(dato).append(
                '<tr>' +
                    '<td scope="row"><strong>'+ element.clave_articulo +'</strong></td>'+
                    '<td>'+element.nombre_articulo+'</td>'+
                    '<td>' + element.nombre_med +'</td>' +
                    '<td>' + element.nombre_partida +'</td>' +                             
                    '<td>' +
                        '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#articuloEdit'+element.id+'">' +
                        '<i class="fa-regular fa-pen-to-square"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#articuloShow'+element.id+'">' +
                            '<i class="fas fa-eye"></i>' +
                        '</button>' +
                    '</td>'+  
                    '<td></td>'+
                '</tr>'
            );
        });
        var cellsOfRow="";
        var found=false;
        var compareWith="";
        for (var i = 1; i < tabla.rows.length; i++) {
            cellsOfRow = tabla.rows[i].getElementsByTagName('td');
            found = false;
            for (var j = 0; j < cellsOfRow.length && !found; j++) { compareWith = cellsOfRow[j].innerHTML.toLowerCase(); if (busqueda.length == 0 || (compareWith.indexOf(busqueda) > -1))
                {
                    found = true;
                }
            }
            if(found)
            {
                tabla.rows[i].style.display = '';
            } else {
                tabla.rows[i].style.display = 'none';
            }

        }
    });
}
</script>
@endsection