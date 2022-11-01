@extends('sideb')
@section('content')
<br>
<div class="row">
    <div class="col-3 py-2">
        <h5><i class="fa-solid fa-file-invoice-dollar fa-2x"></i> &NonBreakingSpace; Facturas</h5>
    </div>
</div>
<div class="container bg-white col-md-10 col-sm-12 col-11">
    <div class="table-responsive">
        <table class="table ">
            <thead>
            <tr>
                <th scope="col">Folio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Monto total</th>
                <th scope="col" style="width: 150px;">Acciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('factura.create')}}" class="btn btn-success">
                        <i class="far fa-plus-square"></i>
                    </a>
                </th>               
            </tr>
            </thead>
            <tbody>            
                @if ($facturas->isNotEmpty())
                    @foreach ( $facturas as $factura )
                        <tr>
                            <th scope="row">{{$factura->folio}}</th>
                            <td>{{$factura->fecha}}</td>
                            @foreach ($proveedores as $proveedor )
                                @if ($proveedor->id_proveedor == $factura->proveedor_id)  
                                 <td>{{$proveedor->nombre_empresa}}</td>                              
                                @else
                                    @if ($factura->proveedor_id == null)
                                        <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de provedor</span></td> 
                                    @endif
                                @endif
                            @endforeach
                            <td>{{$factura->imp_total}}</td>  
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#facturaShow{{$factura->id_factura}}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('factura.edit',$factura->id_factura)}}" class="btn btn-primary">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </td>                   
                        </tr>                    
                    @endforeach
                @else
                    <td colspan="5" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
    </div>
    @if ($facturas->isNotEmpty())   
        @foreach ($facturas as $encabezado)
            @include('Factura.show')
        @endforeach
    @endif
</div>
@endsection