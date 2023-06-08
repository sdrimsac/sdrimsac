<html>

<head>
    <style>
        @page {
            margin: 0.5cm 0.5cm .5cm 0.5cm;
            font-family: sans-serif;
        }

        /** Defina ahora los márgenes reales de cada página en el PDF **/
        body {
            margin: .5cm 0cm 0.5cm 0cm;
        }

        /** Definir las reglas del encabezado **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            height: 0.5cm;
            /** Estilos extra personales **/
            color: #000;
            text-align: left;
            line-height: 0.5cm;
        }

        /** Definir las reglas del pie de página **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0.8cm;

            /** Estilos extra personales **/
            color: #000;
            text-align: center;
        }

        table {
            width: 100%;
            border-spacing: 0;
            font-size: 10px;
        }

        td {
            height: 30px;
            border-bottom: 1px solid #ccc;
            padding-left: 5px;
            padding-right: 5px;
        }

        td,
        th {
            font-size: 11px !important;
        }

        .celda {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
            font-size: 11px;
        }

        .title {
            font-weight: bold;
            padding: 3px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        .center {
            text-align: center !important;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <table width="100%" border="0" style="border-collapse: collapse;border-bottom:1px solid #ddd;">
            <tr>
                <td width="70%" height="30" align="left" valign="top">
                    @if ($company->logo != null)
                        <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}" height="30" />
                    @endif
                </td>
                <td width="30%" height="30" align="right" valign="middle"
                    style="font-size:16px !important;  font-family: sans-serif !important;">Reporte de Inventario de
                    Productos</td>
            </tr>
        </table>
    </header>
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <p>
            @if (!empty($reports))
                @if ($typeresult == 'Detallado')
                    <?php
                    $conteo = 0;
                    $importe = 0;
                    $importe_categoria = 0;
                    $importe_utilidad = 0;
                    $iteration = -1;
                    
                    ?>

                    @foreach ($reports as $key => $value)
                        <?php
                        $iteration++;
                        ?>
                        @if (count($value['item']) > 0)
                            <table width="100%" style="border:1px solid #ccc" border="0" cellpadding="0"
                                cellspacing="0">
                                <tr>
                                    <th colspan="7"
                                        style=" text-align:left !important;color:#000;background-color:#ccc;padding:3px;font-size:14px !important">
                                        CATEGORIA: {{ strtoupper($value['name']) ?? '' }}</th>
                                </tr>
                                <tr>
                                    <th class="celda center">#</th>
                                    <th class="celda">Descripción</th>
                                    <th class="celda center">Inventario actual</th>
                                    <th class="celda center">Costo</th>
                                    <th class="celda center">Precio de venta</th>
                                    <th class="celda center">Inversion</th>
                                    <th class="celda center">Margen Utilidad</th>
                                </tr>

                                @foreach ($value['item'] as $values)
                                    <?php
                                    $iteration++;
                                    $conteo++;
                                    if ($values->stock > 0) {
                                        $importe = $importe + $values->purchase_unit_price * $values->stock;
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td class="celda center" width="30px">{{ $iteration }}</td>
                                        <td class="celda" width="250px">{{ $values->description ?? '' }}
                                            @isset($values->item_lots)
                                                @if (count($values->item_lots) > 0)
                                                <br>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: left">
                                                                    <small>Serie</small>
                                                                </th>
                                                                <th style="text-align: left">
                                                                    <small>Fecha</small>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($values->item_lots as $lots)
                                                                <tr>
                                                                    <td>
                                                                        <small>

                                                                            {{ $lots->series }}
                                                                        </small>
                                                                    </td>
                                                                    <td>
                                                                        <small>

                                                                            {{ $lots->date }}
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endisset
                                        </td>
                                        <td class="celda center">{{ $values->stock ?? '0.00' }}</td>
                                        <td class="celda center">{{ number_format($values->purchase_unit_price, 2) }}
                                        </td>
                                        <td class="celda  center">
                                            {{ number_format($values->sale_unit_price, 2) ?? '0.00' }}</td>
                                        @if ($values->stock > 0)
                                            <td class="celda  center">
                                                {{ number_format($values->purchase_unit_price * $values->stock, 2) ?? '0.00' }}
                                            </td>
                                        @else
                                            <td class="celda  center">0</td>
                                        @endif
                                        @if ($values->stock > 0)
                                            <?php
                                            $conteo++;
                                            if ($values->stock > 0) {
                                                $importe_utilidad = $importe_utilidad + ($values->sale_unit_price - $values->purchase_unit_price) * $values->stock;
                                            }
                                            ?>
                                            <td class="celda  center">
                                                {{ number_format(($values->sale_unit_price - $values->purchase_unit_price) * $values->stock, 2) ?? '0.00' }}
                                            </td>
                                        @else
                                            <td class="celda  center">0</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    @endforeach
                    <table>
                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL CAPITAL S/. {{ number_format($importe, 2) }} </b>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL UTILIDAD S/. {{ number_format($importe_utilidad, 2) }} </b>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL S/. {{ number_format($importe_utilidad + $importe, 2) }} </b>
                            </td>
                        </tr>
                    </table>
                @else
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <?php
                        $importe_utilidad = 0;
                        $capital = 0;
                        $importe = 0;
                        ?>
                        @foreach ($reports as $key => $value)
                            @foreach ($value['item'] as $values)
                                <?php
                                if ($values->stock > 0) {
                                    $importe = $importe + $values->purchase_unit_price * $values->stock;
                                }
                                if ($values->stock > 0) {
                                    $importe_utilidad = $importe_utilidad + ($values->sale_unit_price - $values->purchase_unit_price) * $values->stock;
                                }
                                ?>
                            @endforeach
                        @endforeach

                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL CAPITAL S/. {{ number_format($importe, 2) }} </b>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL UTILIDAD S/. {{ number_format($importe_utilidad, 2) }} </b>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" style="font-size:11px !important;padding-top:8px;padding-bottom:8px;">
                                <b>TOTAL S/. {{ number_format($importe_utilidad + $importe, 2) }} </b>
                            </td>
                        </tr>
                    </table>
                @endif
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>
            @endif
        </p>
    </main>
    <footer>
        <table width="100%" border="0">
            <tr>
                <td align="left" valign="middle">Direccion:{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }} -
                    Telefonos: {{ $establishment->telephone }} Email: {{ $establishment->email }}</td>
            </tr>
        </table>
    </footer>
</body>

</html>
