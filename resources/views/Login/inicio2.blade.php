@extends('sideb')
@section('content')
<section class="vh-100 gradient-custom">
  <div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center ">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5" style="width: 380px;">
        <div class="card bg-white text-dark" style="border-radius: 1rem;">
          <div class="card-body p-10 text-center" style="height: 400px; align-self: center">
            <div class="mb-md-5 mt-md-8 pb-6" >
              <form action="/" method="post" novalidate>
              @csrf
              <h4 class="fw-bold mb-2 text-uppercase">¡Bienvenido!</h4>
              <br>
              <div class="form-outline form-dark mb-4">
                <label class="form-label" for="nombre_usuario">Nombre de usuario</label>
                <input type="text"  autofocus id="nombre_usuario" style="width: 250px" name = "nombre_usuario" class="form-control form-control-md @error('nombre_usuario') is-invalid @enderror" value="{{old('nombre_usuario')}}">
                @error('nombre_usuario')
                  <span class="invalid-feedback col-8">
                      <small>
                        {{$message}}
                      </small>
                  </span>
                @enderror
              </div>
              <div class="form-outline form-dark mb-4">
                <label class="form-label" for="contrasena">Contraseña</label>
                <input type="password"   aria-invalid="false" autofocus id="contrasena"  style="width: 250px" name= "contrasena" class="form-control form-control-md @error('contrasena') is-invalid @enderror">
                @error('contrasena')
                  <span class="invalid-feedback">
                      <small>
                        {{$message}}
                      </small>
                  </span>
                @enderror
              </div>  
              <button class="btn btn-outline-dark btn-md px-5" type="submit">Login</button>
            </form>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection