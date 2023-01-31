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
        margin-top: 5.5cm;
        margin-left: 2cm;
        margin-right: 2cm;
        margin-bottom: 3cm;
        }
        
        header {
        position: fixed;
        top: 1.5cm;
        left: 2cm;
        right: 0cm;
        height: 2cm;
        }
        footer {
        position: fixed;
        bottom: 0cm;
        left: 3.5cm;
        right: 0cm;
        height: 3.5cm;
        
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
                <h5 class="text-center font-weight-bold"><small class="font-weight-bold">SECRETARÍA DE INFRAESTRUCTURA Y OBRAS PÚBLICAS</small></h5>
                <h6 class="text-center small font-weight-bold">Unidad Administrativa</h6>
                <h6 class="text-center small font-weight-bold">Departamento de Recursos Materiales y Servicios Generales de la SIOP</h6>
                <h6 class="text-center small font-weight-bold">Oficina de Control de Inventarios (Almacén de Suministros)</h6>
                <h6 class="text-center small font-weight-bold">{{$partida->descripcion_partida}} - {{$partida->nombre_partida}}</h6>
                <h6 class="text-center small font-weight-bold">CIERRE DE MES</h6>
                <h6 class="text-center small font-weight-bold">Del {{$fechaIni}} al {{$fechaFin}}</h6>
            </div>
        </div>
    </header>
    <footer >
        <div class="row justify-content-center py-4">
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">Vo. Bo.</h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">REVISÓ</h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">ELABORÓ</h6>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">
                ____________________________________
                 LIC. HÉCTOR MARTÍNEZ OLIVER
                </h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">
                ____________________________________
                 C. CLAUDIA PASTRANA GONZÁLEZ
                </h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">
                ____________________________________
                C. ARMANDO DAUZÓN FLORES
                </h6>
            </div>
        </div>
    </footer>
    <main>
        <table class="table table-bordered table-sm" style="page-break-after: never; background-color: white">
            <thead >
            <tr style="background-color: rgb(189, 189, 189)">
                <th class="border border-dark" scope="col">Origen del Recurso</th>
                <th class="border border-dark" scope="col">Articulo</th>
                <th class="border border-dark" scope="col">Unidad de Medida</th>
                <th class="border border-dark" scope="col">Precio Unitario</th>
                <th class="border border-dark" scope="col">Existencia Anterior</th>
                <th class="border border-dark" scope="col">Entrada</th>
                <th class="border border-dark" scope="col">Salida</th>
                <th class="border border-dark" scope="col">Existencia</th>
                <th class="border border-dark" scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($recursos as $recurso)
                    @foreach ($articulos as $articulo)
                      
                            @if (isset($prueba0[$recurso->id_origen][$articulo->id][0]) && $prueba0[$recurso->id_origen][$articulo->id][0]->clave_articulo == $articulo->clave_articulo && $prueba0[$recurso->id_origen][$articulo->id][0]->recurso_id)
                                <tr>
                                    <th class="border border-dark" scope="row">{{$recurso->nombre_recurso}}</th>
                                    <th class="border border-dark">{{$prueba0[$recurso->id_origen][$articulo->id][0]->clave_articulo}} {{$prueba0[$recurso->id_origen][$articulo->id][0]->nombre_articulo}}</th>
                                    <td class="border border-dark">{{$prueba0[$recurso->id_origen][$articulo->id][0]->nombre_med}}</td>
                                    <td class="border border-dark">${{$prueba0[$recurso->id_origen][$articulo->id][0]->precio}}</td> 
                                    @if (isset($inventario_0[$recurso->id_origen][$articulo->id][0]->inventario_0))
                                    <td class="border border-dark">{{$inventario_0[$recurso->id_origen][$articulo->id][0]->inventario_0}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif 
                                    @if (isset($cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]->suma_existencia0))
                                    <td class="border border-dark">{{$cantidad_existencia_recursoE[$recurso->id_origen][$articulo->id][0]->suma_existencia0}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif 
                                    @if (isset($salida_vales[$recurso->id_origen][$articulo->id][0]->cantidad_salidas))
                                    <td class="border border-dark">{{$salida_vales[$recurso->id_origen][$articulo->id][0]->cantidad_salidas}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif
                                    @if (isset($prueba0[$recurso->id_origen][$articulo->id][0]->precio))
                                    <td class="border border-dark">{{$prueba0[$recurso->id_origen][$articulo->id][0]->suma_0}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif   
                                    <th class="border border-dark">${{$prueba0[$recurso->id_origen][$articulo->id][0]->suma_0 * $prueba0[$recurso->id_origen][$articulo->id][0]->precio}}</th>   
                                </tr>
                            @endif
                            @if (isset($prueba01[$recurso->id_origen][$articulo->id][0]->precio) && $prueba01[$recurso->id_origen][$articulo->id][0]->clave_articulo == $articulo->clave_articulo &&  $recurso->id_origen == $prueba01[$recurso->id_origen][$articulo->id][0]->recurso_id)
                                <tr>
                                    <th class="border border-dark" scope="row">{{$recurso->nombre_recurso}}</th>
                                    <th class="border border-dark">{{$prueba01[$recurso->id_origen][$articulo->id][0]->clave_articulo}} {{$prueba01[$recurso->id_origen][$articulo->id][0]->nombre_articulo}}</th>
                                    <td class="border border-dark">{{$prueba01[$recurso->id_origen][$articulo->id][0]->nombre_med}}</td>
                                    <td class="border border-dark">${{$prueba01[$recurso->id_origen][$articulo->id][0]->precio}}</td>
                                    @if (isset($inventario_01[$recurso->id_origen][$articulo->id][0]->inventario_01))
                                    <td class="border border-dark">{{$inventario_01[$recurso->id_origen][$articulo->id][0]->inventario_01}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif
                                    @if (isset($cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->suma_existencia01))
                                    <td class="border border-dark">{{$cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->suma_existencia01}}</td> 
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif 
                                    @if (isset($salida_vales1[$recurso->id_origen][$articulo->id][0]->cantidad_salidas1))
                                    <td class="border border-dark">{{$salida_vales1[$recurso->id_origen][$articulo->id][0]->cantidad_salidas1}}</td>
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif
                                    @if (isset($salida_vales1[$recurso->id_origen][$articulo->id][0]->cantidad_salidas1) && isset($cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->suma_existencia01) && isset($inventario_01[$recurso->id_origen][$articulo->id][0]->inventario_0))
                                    <td class="border border-dark">{{$inventario_01[$recurso->id_origen][$articulo->id][0]->inventario_01 + $cantidad_existencia_recursoE1[$recurso->id_origen][$articulo->id][0]->suma_existencia01 - $salida_vales1[$recurso->id_origen][$articulo->id][0]->cantidad_salidas1}}</td>
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif
                                    @if (isset($prueba01[$recurso->id_origen][$articulo->id][0]->precio))
                                        @if ($prueba01[$recurso->id_origen][$articulo->id][0]->suma_1 != 0)
                                        <th class="border border-dark">{{$prueba01[$recurso->id_origen][$articulo->id][0]->suma_1}}</th> 
                                        @endif
                                    @else
                                    <td class="border border-dark">0</td> 
                                    @endif
                                    <th class="border border-dark">${{$prueba01[$recurso->id_origen][$articulo->id][0]->suma_1 * $prueba01[$recurso->id_origen][$articulo->id][0]->precio}}</th>
                                </tr>
                            @endif
                    @endforeach
                @endforeach
            <tr>
                <th class="border border-dark" colspan="8" style="text-align: right">T o t a l:</th> 
                <th id="totalFinal"class="border border-dark" style="color: red">${{$total_f[0]->total_f}}</th>
            </tr>       
            </tbody>
        </table>
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