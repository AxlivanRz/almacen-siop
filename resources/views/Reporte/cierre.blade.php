@extends('sideb')
@section('content')
<div class="card col-12 mx-2 my-5 ">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            {{-- Encabezado --}}
            <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Cierre mensual</button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <form  class="row needs-validation" action="/cierre" novalidate>
                    @csrf
                    <div class="row">
                        <div class="form-grop col-3">
                            <label>Selecciona el mes</label>
                            <input type="month" id="mesCierre" name="mesCierre" class="form-control" required>
                            <div class="invalid-feedback">Este campo No Puede estar vacío</div>
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
