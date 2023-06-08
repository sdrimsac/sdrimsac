<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Reporte Inventario</strong></h3>
    </div>
    <br>
    <div style="margin-top:20px; margin-bottom:15px;">
        <table>
            <tr>
                <td>
                    <p><b>Empresa: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $company->name }}</strong></p>
                </td>
                <td>
                    <p><strong>Fecha: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ date('Y-m-d') }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
                <td>
                    <p><strong>Establecimiento: </strong></p>
                </td>
                <td align="center">{{ $establishment->address }} - {{ $establishment->department->description }} -
                    {{ $establishment->district->description }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        @if ($typeresult == 'Detallado')
            <table cellpadding="0" cellspacing="0" border="0">
                <?php
                $conteo = 0;
                $importe = 0;
                $importe_categoria = 0;
                $importe_utilidad = 0;
                ?>
                @foreach ($records as $key => $value)
                    <tbody>
                        <tr>
                            <th class=""
                                style=" text-align:left !important;color:blue;padding:3px;font-size:16px">
                                {{ $value->name ?? '' }}</th>
                        </tr>
                        <tr>
                            <td class="celda" align="left">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th>#</th>
                                        <th>Descripción</th>
                                        <th>Inventario actual</th>
                                        <th>Costo</th>
                                        <th>Precio de venta</th>
                                        <th>Inversion</th>
                                        <th>Margen Utilidad</th>
                                        <th>Almacén</th>
                                    </tr>

                                    @foreach ($value['item'] as $values)
                                        <?php
                                        $conteo++;
                                        $iw = 0;
                                        if ($warehouse_id) {
                                            //find index of warehouse;
                                            foreach ($values->warehouses as $k => $w) {
                                                if ($w->warehouse_id == $warehouse_id) {
                                                    $iw = $k;
                                                    break;
                                                }
                                            }
                                        }
                                        $importe = $importe + $values->purchase_unit_price * $values->warehouses[$iw]->stock;
                                        
                                        ?>
                                        <tr>
                                            <td  valign="top" class="celda">{{ $loop->iteration }}</td>
                                            <td valign="top"  class="celda">
                                                {{ $values->description ?? '' }}

                                                @isset($values->item_lots)
                                                    @if (count($values->item_lots) > 0)
                                                        @foreach ($values->item_lots as $lot)
                                                            <p>
                                                                <small>{{ $lot->series }}  {{ $lot->date }}</small> 
                                                            </p>
                                                        @endforeach
                                                    @endif
                                                @endisset
                                            </td>
                                            <td valign="top"  class="celda center">{{ $values->warehouses[$iw]->stock ?? '0.00' }}
                                            </td>
                                            <td valign="top"  class="celda center">
                                                {{ number_format($values->purchase_unit_price, 2) }}</td>
                                            <td valign="top"  class="celda  center">
                                                {{ number_format($values->sale_unit_price, 2) ?? '0.00' }}</td>
                                            @if ($values->warehouses[$iw]->stock > 0)
                                                <td valign="top" class="celda  center">
                                                    {{ number_format($values->purchase_unit_price * $values->warehouses[$iw]->stock, 2) ?? '0.00' }}
                                                </td>
                                            @else
                                                <td valign="top" class="celda  center">0</td>
                                            @endif
                                            @if ($values->warehouses[$iw]->stock > 0)
                                                <?php
                                                $conteo++;
                                                if ($values->warehouses[$iw]->stock > 0) {
                                                    $importe_utilidad = $importe_utilidad + ($values->sale_unit_price - $values->purchase_unit_price) * $values->warehouses[$iw]->stock;
                                                }
                                                ?>
                                                   <td valign="top" class="celda  center">
                                                    {{ number_format(($values->sale_unit_price - $values->purchase_unit_price) * $values->warehouses[$iw]->stock, 2) ?? '0.00' }}
                                                </td>
                                            @else
                                            <td valign="top" class="celda  center">0</td>
                                            @endif
                                            <td valign="top" class="celda  center">
                                                {{ $values->warehouses[$iw]->warehouse->description }}</td>
                                        </tr>
                                    @endforeach
                                    <tbody>
                                </table>

                            </td>
                        </tr>
                    </tbody>
                @endforeach

            </table>
        @else
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <?php
                $importe_utilidad = 0;
                $capital = 0;
                $importe = 0;
                ?>
                @foreach ($records as $key => $value)
                    @foreach ($value['item'] as $values)
                        <?php
                        
                        $importe = $importe + $values->purchase_unit_price * $values->warehouses[$iw]->stock;
                        if ($values->warehouses[$iw]->stock > 0) {
                            $importe_utilidad = $importe_utilidad + ($values->sale_unit_price - $values->purchase_unit_price) * $values->warehouses[$iw]->stock;
                        }
                        ?>
                    @endforeach
                @endforeach

                <tr>
                    <td align="right"><b>TOTAL CAPITAL S/. {{ number_format($importe, 2) }} </b></td>
                </tr>
                <tr>
                    <td align="right"><b>TOTAL UTILIDAD S/. {{ number_format($importe_utilidad, 2) }} </b></td>
                </tr>
                <tr>
                    <td align="right"><b>TOTAL S/. {{ number_format($importe_utilidad + $importe, 2) }} </b></td>
                </tr>
            </table>
        @endif
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
