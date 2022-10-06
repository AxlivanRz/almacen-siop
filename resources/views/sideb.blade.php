<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Administración de Insumos</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('scripts')
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/iconc.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

    <body style="background-color: #F2F3F4  ;">
    </body>

    <body>
        <!-- navbar -->
        <nav class="navbar border border-0" style="background-color:  #ffffff ;">
            <div class="container" >
                <a class="navbar-brand">SIADIN</a>
                <a class="navbar-brand mb-0  mx-auto d-block"><img class="img-fluid" src="{{ asset('../img/hm-siop-logos.png') }}" style="max-height: 65px;"></a>
            </div>
        </nav>
        <!-- navbar -->
        @auth                           
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
                                    <i class="fa-solid fa-user-large"></i>&nbsp;{{ Auth::user()->nombre}} {{Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->first()->nombre_rol : "" }}
                                </button>                               
                                <div class="collapse" id="drop4">
                                    <div class="card card-body col-md-12 shadow-none p-1 mb-2 bg-white rounded">
                                        <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" data-bs-toggle="modal" data-bs-target="#userLogout" type="button">cerrar sesión</a>                                        
                                    </div>
                                </div>
                            </p>
                            <br>
                            <p>
                                <button class="btn btn-md border border-0 btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#drop" aria-expanded="false" aria-controls="drop" >
                                Catálogos
                                </button>
                            </p>
                            <div class="collapse" id="drop" >
                                <div class="card card-body col-md-12 shadow-none border border-2 p-1 mb-3 bg-white rounded " style="align-content: center">
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('usuario.index')}}">Usuarios</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('up.index')}}">Ups</a>
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
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="{{route('encabezado.index')}}">Alta factura</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Consultar facturas</a>
                                </div>
                            </div>
                            <p>
                                <button class="btn btn-md border border-0 btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#drop2" aria-expanded="false" aria-controls="drop2">
                                Vales
                                </button>
                            </p>
                            <div class="collapse" id="drop2">
                                <div class="card card-body col-md-12 shadow-none p-1 mb-2 bg-white rounded">
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Surtir vale</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Vales surtidos</a>
                                    <a class="btn btn-sm btn-outline-dark border border-0 shadow-none p-1 mb-1 rounded" href="#">Mis vales</a>
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
                                 <h5 style="color: dark; text-align: center;">¿Desea salir, {{ Auth::user()->nombre}}?</h5>                    
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