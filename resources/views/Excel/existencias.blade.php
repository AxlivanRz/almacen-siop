<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            <th>Clave Articulo</th>
            <th>Nombre Articulo</th>
            <th>Medida</th>
            <th>Partida</th>
            <th>Precio</th>
            <th>Precio base</th>
            <th>Impuesto</th>
            <th>Total</th>
            <th>Existencia</th>
            <th>Cantidad</th>
            <th>Número de Factura</th>
            <th>Origen del Recurso</th>
            <th>Fecha Asignada</th>
            <th>Fecha de Creación</th>
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
                            @if ($partida->id == $articulo->partida_id)
                            <td>{{$partida->nombre_partida}}</td>
                            @endif
                        @endforeach
                        <td>{{$entrada->precio}}</td>
                        <td>{{$entrada->base}}</td>
                        <td>{{$entrada->imp_unitario}}</td>
                        <td>{{$entrada->preciofinal}}</td>
                        <td>{{$entrada->existencia}}</td>
                        <td>{{$entrada->cantidad}}</td>
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
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>