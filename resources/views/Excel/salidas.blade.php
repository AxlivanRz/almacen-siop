<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
        <tr>
            <th>Clave Articulo</th>
            <th>Nombre Articulo</th>
            <th>Medida</th>
            <th>Partida</th>
            <th>Precio</th>
            <th>Cantidad Surtida</th>
            <th>Total</th>
            <th>Número de Factura</th>
            <th>Origen del Recurso</th>
            <th>Fecha de salida</th>
            <th>Número de vale solicitado</th>
            <th>Número de vale surtido</th>
            <th>Área que solicita</th>
            <th>Usuario que solicita</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salidas as $salida)
            @foreach ($entradas as $entrada)
                @if ($salida->entrada_articulo_id == $entrada->id)
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
                                <td>{{$salida->cantidad}}</td>
                                <td>{{$salida->total_articulo}}</td>
                                <td>{{$entrada->factura_id}}</td>
                                @foreach ($facturas as $factura)
                                    @if ($factura->numero_factura == $entrada->factura_id)
                                        @foreach ($recursos as $recurso)
                                            @if ($recurso->id_origen == $factura->recurso_id)
                                                <td>{{$recurso->nombre_recurso}}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @foreach ($vales_surtidos as $vale_surtido)
                                    @if ($vale_surtido->id == $salida->vale_surtido_id)
                                        <td>{{$vale_surtido->fecha}}</td>
                                        <td>{{$vale_surtido->id}}</td>
                                        <td>{{$vale_surtido->vale_id}}</td>
                                        @foreach ($vales as $vale)
                                            @if ($vale->id == $vale_surtido->vale_id)
                                                @foreach ($areas as $area)
                                                    @if ($vale->area_id == $area->id_area)
                                                        <td>{{$area->nombre_area}}</td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                        @foreach ($users as $user)
                                            @if ($user->id_usuario == $vale->usuario_id && $user->deleted_at == null)
                                            <td>{{$user->name}} - {{$user->primer_apellido}}</td>
                                            @endif    
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>