@extends('sideb')
@section('content')
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
    <main>
        <table class="table table-bordered table-sm" style="page-break-after: never; background-color: white">
            <thead >
            <tr style="background-color: rgb(189, 189, 189)">
                <th class="border border-dark" scope="col">Partida</th>
                <th class="border border-dark" scope="col">Concepto</th>
                @foreach ($areas as $area )
                <th class="border border-dark" id="{{$area->id_area}}" scope="col">{{$area->nombre_area}}</th>
                @endforeach     
                <th class="border border-dark" scope="col">Total</th>  
            </tr>
            </thead>
            <tbody>
            @foreach ($partidas as $partida)
                <tr id="{{$partida->nombre_partida}}"> 
                    <th class="border border-dark"  id="{{$partida->id_partida}}" scope="row">{{$partida->id_partida}}</th>
                    <td class="border border-dark">{{$partida->nombre_partida}}</td>  
                    @foreach ($areas as $area)
                        @foreach ( $gastos[$area->id_area][$partida->id_partida] as $gasto )
                        @if ($gasto->suma != null)
                        <td class="border border-dark">${{$gasto->suma}}</td>
                        @else
                        <td class="border border-dark">$ 0</td>
                        @endif
                        @endforeach
                    @endforeach
                    <th id="totalPartida"class="border border-dark">${{$gastosPartida[$partida->id_partida]}}</th> 
                </tr>                  
            @endforeach
            <tr>
                <th class="border border-dark" colspan="2" style="text-align: end">T o t a l:</th> 
                @foreach ($areas as $area)
                    <th id="total" class="border border-dark">${{$gastosArea[$area->id_area]}}</th>    
                @endforeach   
                <th id="totalFinal"class="border border-dark" style="color: red">${{$gastoFinal}}</th>
            </tr>       
            </tbody>
        </table>
    </main> 
</body>
</html>
@endsection