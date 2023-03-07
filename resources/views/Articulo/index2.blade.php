@extends('sideb')
@section('content')
@section('Dtables')
<link href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
           {{-- Aquí va el modal de agregar --}}
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
   
@section('jsData')
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@endsection
</div>
    
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
        $(document).ready(function(){
            execut2();
        });
    function execut2() {
        $.ajax({
            url: "{!! route('articulo.tableD') !!}",
            type: "GET",
            dataType: "json",
            success: function(resp){
                $('#tbl0_articulos').DataTable({
                    data: resp.articulos,
                    createdRow: (row, data) =>{
                        $(row).attr('data-id-art', data['id']);
                    }, 
                    columDefs: [
                        {"defaultContent": "---", "targets": "_all"}
                    ],
                    columns: [
                        { 'data': 'clave_articulo'},
                        { 'data': 'nombre_articulo'},
                        { 'data': 'nombre_med'},
                        {
                            "render": function (data, type, row) 
                            {
                             var sSalida = '<td>'+ row['partidas']['descripcion_partida'] + '</td>'
                             return sSalida;    
                            }
                        }
                        
                    ],
                });
            }
        });

    }
    </script>

@endsection