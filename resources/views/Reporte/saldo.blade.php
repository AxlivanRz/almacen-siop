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
                <h6 class="text-center small font-weight-bold">Resumen de saldos</h6>
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
                <th class="border border-dark" scope="col">Descripción</th>
                <th class="border border-dark" scope="col">Inventario Inicial</th>
                <th class="border border-dark" scope="col">Más Entradas</th>
                <th class="border border-dark" scope="col">SubTotal</th>
                <th class="border border-dark" scope="col">Menos Salidas</th>
                <th class="border border-dark" scope="col">Menos Obsoletos</th>
                <th class="border border-dark" scope="col">Inventario Final Real</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($partidas as $partida)
                <tr id="{{$partida->nombre_partida}}"> 
                    <th class="border border-dark"  id="{{$partida->id_partida}}" scope="row">{{$partida->id_partida}} {{$partida->nombre_partida}}</th>
                        @if ($inventarioIni[$partida->id_partida] != null)
                            <td class="border border-dark">${{$inventarioIni[$partida->id_partida]}}</td>
                        @else
                            <td class="border border-dark">$ 0</td>
                        @endif
                        @if ($gastosFacturas[$partida->id_partida] != null)
                            <td class="border border-dark">${{$gastosFacturas[$partida->id_partida]}}</td>
                        @else
                            <td class="border border-dark">$ 0</td>
                        @endif
                        @if ($subtotalPartida[$partida->id_partida] != null)
                            <td class="border border-dark">${{$subtotalPartida[$partida->id_partida]}}</td>
                        @else
                            <td class="border border-dark">$ 0</td>
                        @endif
                        @if ($gastosVales[$partida->id_partida] != null)
                            <td class="border border-dark">${{$gastosVales[$partida->id_partida]}}</td>
                        @else
                            <td class="border border-dark">$ 0</td>
                        @endif
                        <td id="obsoletos"class="border border-dark">$0</td> 
                        @if ($totalPartida[$partida->id_partida] != null)
                            <th class="border border-dark">${{$totalPartida[$partida->id_partida]}}</th>
                        @else
                            <th class="border border-dark">$ 0</th>
                        @endif
                   
                </tr>                  
            @endforeach
            <tr>
                <th class="border border-dark" style="text-align: end">T o t a l:</th> 
                <th class="border border-dark">${{$inventarioIniFinal}}</th>
                <th class="border border-dark">${{$gastosFacturasTotal}}</th>
                <th class="border border-dark">${{$subTotalFinal}}</th>
                <th class="border border-dark">${{$gastosValesFinal}}</th>
                <th class="border border-dark">$0</th>
                <th id="totalFinal"class="border border-dark" style="color: red">${{$inventarioFinal}}</th>
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