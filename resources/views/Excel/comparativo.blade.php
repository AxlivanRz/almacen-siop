<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            <th>Clave Articulo</th>
            <th>Nombre Articulo</th>
            <th>Medida</th>
            <th>Partida</th>
            <th>Precio unitario</th>
            <th>Existencia</th>
            <th>Número de Factura</th>
            <th>Origen del Recurso</th>
            <th>Fecha Asignada</th>
            <th>Fecha de Creación</th>
            <th>Salidas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entradas as $entrada)
            <tr>
                @foreach ($articulos as $articulo)
                    @if ($entrada->articulo_id == $articulo->id)
                        <td>{{$articulo->clave_articulo}}</td>
                        <td>{{$articulo->nombre_articulo}}</td>
                        <td>{{$articulo->nombre_med}}</td>
                        @foreach ($partidas as $partida)
                            @if ($partida->id_partida == $articulo->partida_id)
                            <td>{{$partida->nombre_partida}}</td>
                            @endif
                        @endforeach
                        <td>{{$entrada->precio}}</td>
                        <td>{{$entrada->existencia}}</td>
                        <td>{{$entrada->factura_id}}</td>
                        @foreach ($facturas as $factura)
                            @if ($factura->numero_factura == $entrada->factura_id)
                                @foreach ($recursos as $recurso)
                                    @if ($recurso->id_origen == $factura->recurso_id)
                                        <td>{{$recurso->nombre_recurso}}</td>
                                    @endif
                                @endforeach
                                <td>{{$factura->fecha}}</td>
                                <td>{{$factura->created_at}}</td>
                            @endif
                        @endforeach
                        @if (isset($salidas[$entrada->id][0]->suma) && $salidas[$entrada->id][0]->entrada_articulo_id == $entrada->id)
                            <th>{{$salidas[$entrada->id][0]->suma }}</th>
                        @else
                        <th>0</th>
                        @endif
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>