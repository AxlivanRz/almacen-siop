<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ public_path('css/bootstrap4v.css') }}" type="text/css">
    <title>PDF</title>
    <style>
    @page {
        margin: 0cm 0cm;
        }
        body {
        margin-top: 4cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-bottom: 0cm;
        }
        
        header {
        position: fixed;
        top: 1cm;
        left: 2cm;
        right: 0cm;
        height: 2cm;
        }
    </style>
</head>
<body>
    <header >
        <div class="row">
            <div class=" fixed-top" style="display: inline-block;">
                <img src="{{ public_path('/img/logo-siop.png') }}" style="max-height: 100px;">
            </div>
            <div class="col-1" style="display: inline-block;"></div>
            <div class="col-8 justify-content-center" style="display: inline-block;">
                <h5 class="text-center font-weight-bold small">SECRETARÍA DE INFRAESTRUCTURA Y OBRAS PÚBLICAS</h5>
                <h6 class="text-center small font-weight-bold">Unidad Administrativa</h6>
                <h6 class="text-center small font-weight-bold">Departamento de Recursos Materiales y Servicios Generales de la SIOP</h6>
                <h6 class="text-center small font-weight-bold">Vale solicitado Número {{$vale->id}} - Vale surtido Número {{$surtido->id}}</h6>
            </div>
        </div>
    </header>
    <main>
        <div class="card border border-dark">
            <h5 class="card-title py-3" style="text-align: center">Vale solicitado por usuario </h5> 
            <div class="form-group col-2" style="display: inline-block">
                <label>Fecha de solicitado</label>
                <input class="form-control form-control-sm border border-dark" type="text" value = "{{$vale->fecha}}">
            </div>
            <div class="form-group col-1" style="display: inline-block">
                <label>Estatus</label>
                @if ($vale->status == 4)
                   <input class="form-control form-control-sm border border-dark" type="text" value = "Surtido por Almacén">
                @endif
            </div>
            <div class="form-group col-2" style="display: inline-block">
                @if ($vale->fecha_aprovado != null)
                <label>Fecha de aprobado</label>
                <input class="form-control form-control-sm border border-dark" type="text" value = "{{$vale->fecha_aprovado}}">
                @endif
            </div>
            <div class="form-group col-2" style="display: inline-block">
                <label>Solicitado por:</label>
                @foreach ($usuarios as $usuario )
                    @if ($usuario->id_usuario == $vale->usuario_id)
                    <input type="text" class="form-control form-control-sm border border-dark" id= "name" value="{{$usuario->name}} {{$usuario->primer_apellido}} {{$usuario->segundo_apellido}}">
                    @endif
                @endforeach
            </div>
            <div class="form-group col-2" style="display: inline-block">
                @foreach ($usuarios as $usuario )
                    @if ($vale->usuario_id == $usuario->id_usuario)
                        @if ($usuario->departamento_id != null)
                            @foreach ($departamentos as $departamento)
                                @if ($departamento->id_departamento == $usuario->departamento_id)
                                <label>Departamento</label>
                                <input class="form-control form-control-sm border border-dark" type="text" value = "{{$departamento->nombre_departamento}}">
                                @endif
                            @endforeach
                        @else
                            @foreach ($areas as $area)
                                @if ($area->id_area == $usuario->area_id)
                                <label>Área</label>
                                <input class="form-control form-control-sm border border-dark" type="text" value = "{{$area->nombre_area}}">
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endforeach
            </div>
            @foreach ($valeArticulos as $vArticulo)
                <div>
                    <div class="form-group col-5" style="display: inline-block">
                        @if ($vale->articulos->isNotEmpty())
                            @if ($valeArticulos !=null)
                                <label>Articulo</label>                                     
                                <input class="form-control form-control-sm border border-dark" type="text" value="{{$vArticulo->nombre_articulo}} - {{$vArticulo->nombre_med}}" >
                            @endif
                        @endif
                    </div>
                    <div class="form-group col-5" style="display: inline-block">
                        <label>Cantidad</label>
                        <input class="form-control form-control-sm border border-dark" name="cantidadkey[]" id="cantidad" type="text" value = "{{$vArticulo->pivot->cantidad}}">
                    </div>
                </div>
            @endforeach 
        </div>
        <br>
        <div class="card border border-dark">
            <h5 class="card-title py-3" style="text-align: center">Vale surtido almacén</h5>
            @foreach ($queryEFAs as $queryEFA)
            <div>
                <div class="form-group col-3" style="display: inline-block">
                    <label>Articulo</label>
                    <input type="text" class="form-control form-control-sm border border-dark" value="{{$queryEFA->nombre_articulo}}-{{$queryEFA->nombre_med}}">
                </div>
                <div class="form-group col-2" style="display: inline-block">
                    <label>Número de factura</label>
                    <input type="text" class="form-control form-control-sm border border-dark" value="{{$queryEFA->factura_id}}">
                </div>
                <div class="form-group col-2" style="display: inline-block">
                    <label>Precio</label>
                    <input type="text" class="form-control form-control-sm border border-dark"  value="${{$queryEFA->precio}}">
                </div>
                <div class="form-group col-2" style="display: inline-block">
                    <label>Cantidad</label>
                    <input type="text" class="form-control form-control-sm border border-dark"value="{{$queryEFA->cantidad}}">
                </div>
            </div>
            @endforeach
            <div class="form-group col-2"  style="display: inline-block">
                @foreach ($usuarios as $usuario )
                    @if ($vale->administrador_id == $usuario->id_usuario)
                        <label>Aprobado por</label>
                        <input class="form-control form-control-sm border border-dark" type="text" value = "{{$usuario->name}} {{$usuario->primer_apellido}}">
                    @endif
                @endforeach
            </div>
            <div class="form-group col-2"  style="display: inline-block">
                <label>Surtido por:</label>
                @foreach ($usuarios as $usuario )
                    @if ($usuario->id_usuario == $surtido->capturista_id)
                    <input type="text" class="form-control form-control-sm border border-dark" value="{{$usuario->name}} {{$usuario->primer_apellido}} {{$usuario->segundo_apellido}}">
                    @endif
                @endforeach
            </div>
            <div class="form-group col-2"  style="display: inline-block">
                <label >Fecha de surtido</label>
                <input type="text" class="form-control form-control-sm border border-dark" value="{{$surtido->fecha}}">
            </div>
            <div class="form-group col-2"  style="display: inline-block">
                <label >Total del vale</label>
                <input type="text" class="form-control form-control-sm border border-dark" value="${{$surtido->total}}">
            </div>
        </div>
    </main>
        
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(750, 560, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
                ');
            }
        </script>
        
</body>
</html>   