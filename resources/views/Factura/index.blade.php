@extends('sideb')
@section('buscar')
<script src="{{ asset('js/search.js') }}" defer></script>
@endsection
@section('content')
<br>
<div class="row">
    <div class="col-3 py-3">
        <h5><i class="fa-solid fa-file-invoice-dollar fa-2x"></i> &NonBreakingSpace;Facturas con existencia</h5>
    </div>
    <div class="col-9 d-md-flex justify-content-end my-3 px-5">
        <div class="col-5">
            <form action="/factura" method="get">
                <div class="btn-group col-11">
                    <input type="text" name="busqueda" id="search" onkeyup="Buscar()" class="form-control form-control-sm border border-2 border-primary" placeholder="Ingrese el número de la factura">
                    <input type="submit" value="Buscar" class="btn btn-sm btn-primary">
                </div>
            </form>
        </div>        
    </div>
</div>
<div class="container card bg-white col-md-10 col-sm-12 col-11">
    <div class="card-body">
        {{-- Facturas sin existencia --}}
        <div class="table-responsive">
            <table class="table" id="table_search">
                <thead>
                <tr>
                    <th scope="col">Folio</th>
                    <th scope="col">Número de Factura</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Monto total</th>
                    <th scope="col">Estatus existencia</th>
                    <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('factura.create')}}" class="btn btn-success">
                            <i class="far fa-plus-square"></i>
                        </a>
                    </th>  
                </tr>
                </thead>
                <tbody>            
                    @if ($facturasExis->isNotEmpty())
                        @foreach ($facturasExis as $facturaE )
                            <tr>
                                <th scope="row">{{$facturaE->id_factura}}</th>
                                <td>{{$facturaE->numero_factura}}</td>
                                <td>{{$facturaE->fecha}}</td>
                                @foreach ($proveedores as $proveedor )
                                    @if ($proveedor->id_proveedor == $facturaE->proveedor_id)  
                                    <td>{{$proveedor->nombre_empresa}}</td>                              
                                    @else
                                        @if ($facturaE->proveedor_id == null)
                                            <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de provedor</span></td> 
                                        @endif
                                    @endif
                                @endforeach
                                <td>${{$facturaE->imp_total}}</td>
                                <td>
                                    <span class="badge rounded-pill bg-success">Con existencias</span>
                                </td>
                                <td>
                                    <a href="{{ route('factura.show',$facturaE->id_factura)}}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('factura.edit',$facturaE->id_factura)}}" class="btn btn-sm btn-primary" {{$facturaE->confirmed == 1 ? 'hidden' : ''}}>
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                </td>                   
                            </tr>                    
                        @endforeach
                    @else
                        <td colspan="8" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                    @endif                            
                </tbody>
            </table>
            <div class = "d-flex">{{$facturasExis->links()}}</div>
        </div>
        {{-- Fin --}}
        
    </div>
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
