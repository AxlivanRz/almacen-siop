<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIADIN</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/img/ico.png') }}">
    <link rel="shortcut icon" sizes="162x162" href="{{ asset('/img/ico.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('scripts')
    @yield('scriptsApi')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/iconc.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
    <body style="background-color: #F2F3F4  ;">
    </body>

    <body>
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg" style="background-color:  #ffffff ;">
            <div class="container-fluid">
              <a class="navbar-brand mx-5 mb-0 px-5">SIADIN</a>
              @can('isVal')
              <a class="navbar-brand mx-4 mb-0 px-5 btn btn-sm btn-outline-success border border-0 shadow-none rounded" href="{{route('vale.index')}}">Vales</a>
              @endcan
              <a class="navbar-brand mb-0 px-5 "><img class="img-fluid" src="{{ asset('../img/hm-siop-logos.png') }}" style="max-height: 65px;"></a>
              <a class="navbar-brand mx-5 px-5 mb-0"></a>
              @can('isVal')
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav mb-0 mx-5">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-large"></i>&nbsp;{{ Auth::user()->name}} {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->nombre_rol : "" }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink" style="text-align: center">
                        <li><a class="btn btn-outline-danger border border-0 shadow-none p-0 mb-0 rounded" data-bs-toggle="modal" data-bs-target="#userLogout" type="button">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    </ul>
                </div>
              @endcan
            </div>
          </nav>
        <!-- navbar -->
        @auth
        @canany(['isAdmin', 'isTi', 'isAlm']) 
        <div class="d-flex align-items-start ">
            <div class="nav d-flex flex-md-column flex-row me-auto   border border-right border-0 shadow-md p-0 mb-0 bg-white rounded " 
            style="align-items: center; background-color: #FFFFFFFF; min-height: 570px; " id="sidebar" role="tablist">
                <p>
                    <button class="btn btn-ligth" id="prueba-dos" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"  aria-expanded="true" aria-controls="collapseWidthExample">
                        <i id="icon" class="fa-solid fa-angles-left"></i>
                    </button>
                </p>
                <div style="min-height: 120px; ">
                    <div class="collapse collapse-horizontal show" id="collapseWidthExample">
                        <div class="card card-body  border border-0" style="width: 185px;">
                            <p>
                                <button class="btn btn-sm border border-0 btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#drop4" aria-expanded="false" aria-controls="drop4">
                                    <i class="fa-solid fa-user-large"></i>&nbsp;{{ Auth::user()->name}} {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->nombre_rol : "" }}
                                </button>                               
                                <div class="collapse" id="drop4">
                                    <div class="card card-body col-md-12 shadow-none p-1 mb-2 bg-white rounded">
                                        <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" data-bs-toggle="modal" data-bs-target="#userLogout" type="button">cerrar sesión</a>                                        
                                    </div>
                                </div>
                            </p>
                            <br>
                            <p>
                                <a href="{{route('inicio')}}" class= "btn btn-md border border-0 btn-outline-dark" type="button">Inicio</a>
                            </p>
                            <p>
                                <button class="btn btn-md border border-0 btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#drop" aria-expanded="false" aria-controls="drop" >
                                Catálogos
                                </button>
                            </p>
                            <div class="collapse" id="drop" >
                                <div class="card card-body col-md-12 shadow-none border border-2 p-1 mb-3 bg-white rounded " style="align-content: center">
                                    @canany(['isAdmin', 'isTi']) 
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('usuario.index')}}">Usuarios</a>
                                    @endcanany
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('up.index')}}">Unidades Presupuestales</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('area.index')}}">Direcciones/Unidades</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('departamento.index')}}">Departamentos</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('partida.index')}}">Partidas presupuestales</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('proveedor.index')}}">Proveedores</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('recurso.index')}}">Origen recurso</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('unidadesmedicion.index')}}">Unidades de medida</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('articulo.index')}}">Articulos</a>
                                </div>
                            </div>
                            <p>
                                <button class="btn btn-md border border-0 btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#drop1" aria-expanded="false" aria-controls="drop1">
                                Facturas
                                </button>
                            </p>
                            <div class="collapse" id="drop1">
                                <div class="card card-body col-md-12 shadow-none p-1 mb-2 bg-white rounded">
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('factura.index')}}">Alta factura</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Consultar facturas</a>
                                </div>
                            </div>
                            <p>
                                <button class="btn btn-md border border-0 btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#drop3" aria-expanded="false" aria-controls="drop3">
                                Consultas
                                </button>
                            </p>
                            <div class="collapse" id="drop3">
                                <div class="card card-body col-md-12 shadow-none p-1 mb-2 bg-white rounded">
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Reporte diario de salidas</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Inventario</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcanany
            <div class="flex-center position-ref full-height me-auto col-md-10 col-10 offset-0 offset-sm-0 offset-md-0">
                <div class="content ">
                    
                    @yield('content')
                    
                </div>
            </div>
            @else
            <div class="flex-center position-ref full-height col-md-12 ">
                <div class="content ">
                    
                    @yield('content')
                    
                </div>
            </div>
        @endauth
        </div> 
        @auth
        <!-- Logout Modal-->
        <div class="modal fade" id="userLogout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userLogoutLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="width: 450px">
                <div class="modal-header bg-white border-0 " style="height: 50px">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="content" style="align-self: center">
                        <div class="modal-body bg-white">
                                <div class = "row">
                                    <div class="col-md-12">
                                        <div class="mx-auto d-block" style="text-align: center">
                                            <i class="fa-solid fa-arrow-right-from-bracket fa-9x" style = "color: red;"></i>
                                        </div>
                                    </div>
                                </div>
                                    <br>
                                 <h5 style="color: dark; text-align: center;">¿Desea salir {{ Auth::user()->name}}?</h5>                    
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center " style="height: 85px">
                        <div class="modal-footer bg-white border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success">Sí</button>
                            </form>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        @endauth
    </body>
</html>