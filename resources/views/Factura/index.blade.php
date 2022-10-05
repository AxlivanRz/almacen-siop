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
                    <button type="button" class="btn btn-tool btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#encabezadoCreate">
                        <i class="far fa-plus-square"></i>
                    </button>
                </th>               
            </tr>
            </thead>
            <tbody>            
                @if ($encabezados->isNotEmpty())
                    @foreach ( $encabezados as $encabezado )
                        <tr>
                            <th scope="row">{{$encabezado->folio}}</th>
                            <td>{{$encabezado->fecha}}</td>
                            @foreach ($proveedores as $proveedor )
                                @if ($proveedor->id_proveedor == $encabezado->proveedor_id)  
                                 <td>{{$proveedor->nombre_empresa}}</td>                              
                                @else
                                    @if ($encabezado->proveedor_id == null)
                                        <td colspan="1" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros de up</span></td> 
                                    @endif
                                @endif
                            @endforeach
                            @if ($facturas->isNotEmpty())
                                @foreach ($facturas as $factura )
                                    @if ($factura->encabezado_id == $encabezado->id_encabezado)  
                                        <td>$ {{$factura->imp_total}}</td>                              
                                    @else
                                        <td colspan="1" style="text-align: center"> 
                                            <a href="{{ route('factura.form2',$encabezado->id_encabezado)}}" class="btn btn-outline-warning">Continuar con el registro</a>
                                        </td> 
                                    @endif
                                @endforeach
                            @endif               
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button> 
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </td>                   
                        </tr>                    
                    @endforeach
                @else
                    <td colspan="5" style="text-align: center"><span class="badge rounded-pill bg-danger">Sin registros</span></td>
                @endif                            
            </tbody>
        </table>
    </div>
    @if ($encabezados->isNotEmpty())  
        @foreach ($encabezados as $encabezado )
        @endforeach
    @endif
    @include('Factura.create')   
</div>
@endsection