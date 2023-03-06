@extends('sideb')
@section('content')
@section('Dtables')
<link href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js" defer></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@endsection
<br>
<div class="row" id="varArt">
    <div class="col-3 py-2">
        <h5> <i class="fas fa-cubes fa-2x"></i> &NonBreakingSpace; Articulos</h5>
    </div>
</div>
<div class="card">
    <div class="card">
        <div class="card-header" style="justify-items: right">
            <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#articuloCreate">
                <i class="far fa-plus-square"></i>
            </button>   
        </div>
    </div>
    <div class="card-body">
        <table class="table table-responsive bg-white col-md-10 col-sm-12 col-12"  id="tbl0_articulos" style="width:100%">
            <thead>
            <tr>
                <th scope="col">Clave</th>
                <th scope="col">Nombre</th>
                <th scope="col">Unidad de medida</th>
                <th scope="col">Partida</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            
        </table>
    </div>
    <!-- Modal -->
<div class="modal fade" id="articuloShow" style="overflow-y: scroll;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="articuloShowLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-white border-0 " >
                <h5 class="modal-title" id="departamentoEditLabel" >Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="content">
                <div class="modal-body">
                    <div class="col-10 mx-5">
                        <label >Clave</label>
                        <input type="text" class="form-control form-control-sm" id ="claveMD" name ="clave" value="" disabled>
                    </div>
                    <div class="col-10 mx-5">
                        <label >Nombre artículo</label>                
                        <input type="text" class="form-control form-control-sm"  id="nombreArMD" name="nombreAr"  value="" disabled>
                    </div>
                    <div class="col-10 mx-5">
                        <label >Ubicación</label>
                        <input type="text" class="form-control form-control-sm" id ="ubicacionMD" name ="ubicacion"  value="" disabled>
                    </div>
                    <div class="col-10 mx-5">
                        <label >Observaciones</label>
                        <input type="text" class="form-control form-control-sm" id ="observacionesMD" name ="observaciones" value="" disabled>
                    </div>                   
                    <div class="col-10 mx-5">
                        <label >Partida</label>
                        <input type="text" class="form-control form-control-sm" id ="partidaMD" name ="partida" value="" disabled>
                    </div>
                    <div class="col-10 mx-5">                                          
                        <label >Unidad de medida</label>
                        <input type="text" class="form-control form-control-sm" id ="medidaMD" name ="medida" value="" disabled>
                        
                    </div>
                    <br>  
                    <div class="col-10 mx-5">
                       
                        <div class="col-9" id="divIMG">
                            <img src="" id= "imgArt" alt="Foto de articulo" style="height: 120px;">

                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>

</div>
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
    <script>
        function execut() {
            $(document).ready(function () {
                $('#tbl0_articulos').DataTable({
                    ajax: "{!! route('articulo.table') !!}",
                    processing: true,
                    serverSide: true,
                    columns: [
                        { 'data': 'clave_articulo'},
                        { 'data': 'nombre_articulo'},
                        { 'data': 'nombre_med'},
                        { 'data': 'partidas.descripcion_partida'},
                        { 'data': 'actions', orderable:false, searchable:false},
                    ],
                
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                    "lengthMenu": [ [15, 30, 60, -1], [15, 30, 60, "All"] ],
                });
            });
        }
    setTimeout(execut, 2000);
    function idArt(objBtn) {
        var idArtAjx =objBtn.id;
        $.ajax({ 
            type: "GET",
            url: "{{route ('articulo.index')}}",
            data:{'idArtAjx': idArtAjx}
        }).done(function(data){
            $.each(data, function(index, element){
                var clave = document.getElementById('claveMD');
                clave.value = element.clave_articulo;
                var nombre = document.getElementById('nombreArMD');
                nombre.value = element.nombre_articulo;
                var ubicacion = document.getElementById('ubicacionMD');
                ubicacion.value = element.ubicacion;
                var observaciones = document.getElementById('observacionesMD');
                observaciones.value = element.observaciones;
                var partida = document.getElementById('partidaMD');
                partida.value = element.descripcion_partida;
                var medida = document.getElementById('medidaMD');
                medida.value = element.nombre_med;
                var imagen = document.getElementById('imgArt');
                imagen.src = "storage/"+element.foto_articulo;
            }); 
        });
    }
    </script>

@endsection