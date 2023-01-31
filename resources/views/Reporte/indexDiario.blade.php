@extends('sideb')
@section('content')
<div class="card col-12 mx-2 my-5 ">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            {{-- Encabezado --}}
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Resumen de salidas</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Resumen de entradas</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reporte-3" type="button" role="tab" aria-controls="reporte-3" aria-selected="false">Reporte de Diferencias</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reporte-4" type="button" role="tab" aria-controls="reporte-4" aria-selected="false">Resumen de saldos</button>
            </li>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reporte-5" type="button" role="tab" aria-controls="reporte-5" aria-selected="false">Comparativo y Diferencias</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#reporte-6" type="button" role="tab" aria-controls="reporte-6" aria-selected="false">Resumen de Movimientos</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            {{-- Reporte de salidas --}}
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <form  class= "row needs-validation" action="/reporte/salidas" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Fecha de Inicio</label>
                            <input type="date" id="inicio" name="inicio" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-3">
                            <label>Fecha de Terminó</label>
                            <input type="date" id="final" name="final" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-4">
                            <label>Origen del Recurso</label>
                            <select class="form-select" name="recurso" id="recurso" required>
                                <div class="invalid-feedback">Este campo No Puede estar vacío</div>
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
            {{-- Reporte de entradas --}}
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <form  class= "row needs-validation" action="/reporte/entradas" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Fecha de Inicio</label>
                            <input type="date" id="inicio2" name="inicio2" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-3">
                            <label>Fecha de Terminó</label>
                            <input type="date" id="final2" name="final2" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-4">
                            <label>Origen del Recurso</label>
                            <select class="form-select" name="recurso2" id="recurso2" required>
                                <div class="invalid-feedback">Este campo No Puede estar vacío</div>
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
            {{-- Reporte de diferencias --}}
            <div class="tab-pane fade" id="reporte-3" role="tabpanel" aria-labelledby="reporte-3" tabindex="0">
                <form  class="row needs-validation" action="/reporte/diferencias" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Fecha de Inicio</label>
                            <input type="date" id="inicio3" name="inicio3" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-3">
                            <label>Fecha de Terminó</label>
                            <input type="date" id="final3" name="final3" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-1 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Reporte de saldos --}}
            <div class="tab-pane fade" id="reporte-4" role="tabpanel" aria-labelledby="reporte-4" tabindex="0">
                <form  class="row needs-validation" action="/reporte/saldos" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-4">
                            <label>Selecciona el mes</label>
                            <input type="month" id="mes4" name="mes4" class="form-control" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-3 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Reporte comparativo --}}
            <div class="tab-pane fade" id="reporte-5" role="tabpanel" aria-labelledby="reporte-5" tabindex="0">
                <form  class="row needs-validation" action="/reporte/comparativo" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Selecciona el mes</label>
                            <input type="month" id="mes" name="mes" class="form-control" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-4">
                            <label>Partida</label>
                            <select class="form-select" name="partida" id="partida" required>
                                <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                                @foreach ($partidas as $partida)
                                <option value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-grop col-3 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
             {{-- Reporte comparativo --}}
             <div class="tab-pane fade" id="reporte-6" role="tabpanel" aria-labelledby="reporte-6" tabindex="0">
                <form  class="row needs-validation" action="/reporte/movimiento" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Selecciona el mes</label>
                            <input type="month" id="mes_movimiento" name="mes_movimiento" class="form-control" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-4">
                            <label>Partida</label>
                            <select class="form-select" name="partida_movimiento" id="partida" required>
                                <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                                @foreach ($partidas as $partida)
                                <option value="{{$partida->id_partida}}">{{$partida->nombre_partida}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-grop col-3 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        (function () {
          'use strict'
         var forms = document.querySelectorAll('.needs-validation')
         Array.prototype.slice.call(forms)
             .forEach(function (form) {
             form.addEventListener('submit', function (event) {
                 if (!form.checkValidity()) {
                 event.preventDefault()
                 event.stopPropagation()
                 }
                 form.classList.add('was-validated')
             }, false)
             })
         })()
    </script>
</div>
@endsection
