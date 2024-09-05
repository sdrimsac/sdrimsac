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
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td colspan="6"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 14px;">
                        <h3 align="center" class="title"><strong>Reporte Inventario</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3"
                        style=" border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{ $company->name }} </p>
                    </td>
                    <td align="center" colspan="3"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong> {{ date('Y-m-d') }} </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3"
                        style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong> {{ $company->number }} </p>
                    </td>
                    <td align="center" colspan="3"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Establecimiento: </strong>{{ $establishment->address }} -
                            {{ $establishment->department->description }} -
                            {{ $establishment->district->description }}
                        </p>
                    </td>
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
                                    {{ $value->name ?? '' }}
                                </th>
                            </tr>
                            <tr>
                                <td class="celda" align="left">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                #</th>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                Codigo Interno</th>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                Descripción</th>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                Almacén</th>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                Stock</th>
                                            <th
                                                style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                                                Stock real</th>
                                            {{--
                                        <th>Precio de venta</th>
                                        <th>Inversion</th>
                                        <th>Margen Utilidad</th> --}}
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
                                                <td valign="top" class="celda"
                                                    style="text-align: center; border: 2px solid black;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td style="text-align: center; border: 2px solid black;">
                                                    {{ $values->internal_id }}
                                                </td>
                                                <td valign="top" class="celda"
                                                    style="text-align: center; border: 2px solid black;">
                                                    {{ $values->description ?? '' }}

                                                    @isset($values->lots)
                                                        @if (count($values->item_lots) > 0)
                                                            @foreach ($values->item_lots as $lot)
                                                                <p>
                                                                    <small>{{ $lot->series }} {{ $lot->date }}</small>
                                                                </p>
                                                            @endforeach
                                                        @endif
                                                    @endisset
                                                </td>
                                                <td valign="top" class="celda  center"
                                                    style="text-align: center; border: 2px solid black;">
                                                    {{ $values->warehouses[$iw]->warehouse->description }}
                                                </td>
                                                <td valign="top" class="celda center"
                                                    style="text-align: center; border: 2px solid black;">
                                                    {{ $values->warehouses[$iw]->stock ?? '0.00' }}
                                                </td>
                                                <td valign="top" class="celda center"
                                                    style="text-align: center; border: 2px solid black;">
                                                    {{-- {{ $values->warehouses[$iw]->stock ?? '0.00' }} --}}
                                                </td>
                                                {{-- assdsfsfgsgdgdf --}}
                                                {{-- <td valign="top" class="celda center">
                                                    {{ number_format($values->purchase_unit_price, 2) }}
                                                </td> --}}
                                                {{-- <td valign="top" class="celda  center" style="text-align: center; border: 2px solid black">
                                                    {{ number_format($values->sale_unit_price, 2) ?? '0.00' }}
                                                </td> --}}
                                                {{-- @if ($values->warehouses[$iw]->stock > 0)
                                                    <td valign="top" class="celda  center">
                                                        {{ number_format($values->purchase_unit_price * $values->warehouses[$iw]->stock, 2) ?? '0.00' }}
                                                    </td>
                                                @else
                                                    <td valign="top" class="celda  center">0</td>
                                                @endif
                                                @if ($values->warehouses[$iw]->stock > 0)
                                                    <td valign="top" class="celda  center">
                                                        {{ number_format(($values->sale_unit_price - $values->purchase_unit_price) * $values->warehouses[$iw]->stock, 2) ?? '0.00' }}
                                                    </td>
                                                @else
                                                    <td valign="top" class="celda  center">0</td>
                                                @endif --}}


                                            </tr>
                                        @endforeach
                                        <tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    @endforeach
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

                        <tr style="text-align: center; border: 2px solid black;">
                            <td align="right"><b>TOTAL CAPITAL S/. {{ number_format($importe, 2) }} </b></td>
                        </tr>
                        <tr style="text-align: center; border: 2px solid black;">
                            <td align="right"><b>TOTAL UTILIDAD S/. {{ number_format($importe_utilidad, 2) }} </b>
                            </td>
                        </tr>
                        <tr style="text-align: center; border: 2px solid black;">
                            <td align="right"><b>TOTAL S/. {{ number_format($importe_utilidad + $importe, 2) }} </b>
                            </td>
                        </tr>
                    </table>
                </table>
            @endif
        @else
            <div class="callout callout-info">
                <p>No se encontraron registros.</p>
            </div>
        @endif
</body>

</html>
