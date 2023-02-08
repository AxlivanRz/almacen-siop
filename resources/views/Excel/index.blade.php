@extends('sideb')
@section('content')
<div class="card col-12 mx-2 my-5 ">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            {{-- Encabezado --}}
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Exportar datos de Entradas</button>
            </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Exportar datos de Salidas</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            {{-- Reporte de entradas --}}
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <form  class= "row needs-validation" action="/excel/entradas" novalidate>
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
                        <div class="form-grop col-1 my-4">
                            <button type="submit" class="btn btn-success">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Reporte de salidas --}}
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <form  class= "row needs-validation" action="/excel/salidas" novalidate>
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Fecha de Inicio</label>
                            <input type="date" id="inicio1" name="inicio1" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-3">
                            <label>Fecha de Terminó</label>
                            <input type="date" id="final1" name="final1" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
                        </div>
                        <div class="form-grop col-1 my-4">
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