@extends('sideb')
@section('content')
<div class="row">
    <div class="col-1"></div>
    <div class="col-3 py-3 mt-2">
        <h5> <i class="fa-regular fa-file-lines fa-2x"></i> &NonBreakingSpace; Vales / </h5>
    </div>
</div>
<div class="container bg-white col-8">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Unidad presupuestal</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Iniciales</th>
                    <th scope="col" style="width: 150px;">Acciones&nbsp;
                        <a type="button" class="btn btn-tool btn-sm btn-success" href="{{route('vale.create')}}">
                            <i class="far fa-plus-square"></i>
                        </a>
                    </th>
                    
                </tr>
            </thead>
            <tbody>            
                <tr>
                    <th scope="row"></th>                            
                    <td></td>
                    <td></td>
                    <td></td>
                    <td >                                                           
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" >
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>                               
                    </td>                   
                </tr>                
            </tbody>
        </table> 
    </div>
@endsection