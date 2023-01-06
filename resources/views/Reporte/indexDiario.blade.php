@extends('sideb')
@section('content')
<div class="card col-9 mx-5 my-5 ">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Anexo 1</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <form  action="/dd">
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Fecha de Inicio</label>
                            <input type="date" id="inicio" name="inicio" class="form-control" data-inputmask-inputformat="dd/mm/yyyy">
                        </div>
                        <div class="form-grop col-3">
                            <label>Fecha de Terminó</label>
                            <input type="date" id="final" name="final" class="form-control" data-inputmask-inputformat="dd/mm/yyyy">
                        </div>
                        <div class="form-grop col-4">
                            <label>Origen del Recurso</label>
                            <select class="form-select" name="recurso" id="recurso">
                                <option>Seleccione una opción</option>
                                <option value="0">Todos</option>
                                @foreach ($recursos as $recurso)
                                <option value="{{$recurso->id_origen}}">{{$recurso->nombre_recurso}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-grop col-1 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Primer Página --}}
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                1
            </div>
        </div>
    </div>
</div>
@endsection
