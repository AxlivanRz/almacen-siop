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
        margin-top: 6cm;
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
        left: 2.5cm;
        right: 0cm;
        height: 4.5cm;
        
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
                <h6 class="text-center small font-weight-bold">Comparativo y Diferencias entre Registro de Kardex y Vales de Salida</h6>
                <h6 class="text-center small font-weight-bold">CIERRE DE MES</h6>
                <h6 class="text-center small font-weight-bold">Del {{$fechaIni1}} al {{$fechaFin1}}</h6>
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
                __________________________
                 LIC. HÉCTOR MARTÍNEZ OLIVER
                </h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">
                __________________________
                 C. CLAUDIA PASTRANA GONZÁLEZ
                </h6>
            </div>
            <div class="col-3" style="display: inline-block;">
                <h6 class="text-center small">
                ________________________
                C. ARMANDO DAUZÓN FLORES
                </h6>
            </div>
        </div>
    </footer>
    <main>
        <table class="table table-bordered table-sm" style="page-break-after: never;">
            <thead >
            <tr style="background-color: rgb(189, 189, 189)">
                <th class="border border-dark" scope="col">Partida</th>
                <th class="border border-dark" scope="col">Concepto</th>
                <th class="border border-dark" scope="col">Kardex</th>
                <th class="border border-dark" scope="col">Vales</th>
                <th class="border border-dark" scope="col">Diferencia</th>
            </tr>
            </thead>
            <tbody >            
                @foreach ($partidas as $partida )
                    <tr>
                        <th class="border border-dark" scope="row">{{$partida->descripcion_partida}}</th>
                        <td class="border border-dark">{{$partida->nombre_partida}}</td>
                        <td class="border border-dark">${{$gastosFacturas[$partida->id_partida]}}</td>
                        <td class="border border-dark">${{$gastosVales[$partida->id_partida]}}</td>
                        <th class="border border-dark">${{$diferenciasFVP[$partida->id_partida]}}</th>                                     
                    </tr>              
                @endforeach 
                <tr>
                    <th colspan="2" style="border-bottom-color: white; border-left-color: white; border-right-color: black;text-align: right">Total:</th>
                    <th class="border border-dark">${{$gastoFinalFac}}</th>   
                    <th class="border border-dark">${{$gastoFinalVal}}</th>   
                    <th class="border border-dark py-1" style="color: red">${{$diferenciaTotal}}</th>   
                </tr>                      
            </tbody>
        </table>
    </main>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(500, 810, "Página $PAGE_NUM de $PAGE_COUNT", $font, 10);
                ');
            }
        </script>
</body>
</html>