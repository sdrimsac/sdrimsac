<?php

function format_unit($row, $uit)
{
    $max_quantity_item = $row['max_quantity_item'];
    $unit_type = $row['unit_type'];
    $unit_item = $row['unit_item'];
    $count = $uit['count'] * $uit['factor'];
    $full = intdiv($count, $max_quantity_item);
    $rest = $count % $max_quantity_item;
    echo '(' . number_format($uit['count'], 2) . ')' . ' ' . ($full == 0 ? '' : $full . ' ' . $unit_item) . ' ' . ($rest == 0 ? '' : $rest . ' ' . $unit_type);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @php
    $gain_total = 0;
    @endphp
    <table>


        <tr>
            <td colspan="8" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                <p><strong>Reporte de Ganancias</strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC;">
                <p><strong>Empresa: </strong>{{ $company->name }}</p>
            </td>
            <td colspan="3" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                <p><strong>Fechas: </strong>{{ $date_start }}
                    @if ($date_end)
                    - {{ $date_end }}
                    @endif
                </p>
            </td>
        </tr>
        <tr>
            @if ($establishment)
            <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC;">
                <p><strong>Establecimiento: </strong>{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }}
                </p>
            </td>
            <td colspan="3" style="border: 2px solid black; background-color: #DCDCDC;">
                <p><strong>Ruc: </strong>{{ $company->number }}</p>
            </td>
            @else
            <td colspan="3"></td>
            @endif
        </tr>


        @if (!empty($items))



        <thead class="thead">
            <tr>
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#</th>
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Producto</th>
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Cant. Total</th>
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Unidad medida</th>
                @if (!$is_service)
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">P.C.</th>
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">P.V.</th>
                @endif
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Total</th>
                @if (!$is_service)
                <th class="th" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Utilidad</th>
                @endif
            </tr>
        </thead>
        @php
        $index = 1;
        @endphp
        <tbody>
            @foreach ($items as $value)
            @foreach ($value['prices'] as $price => $count)
            <tr>
                <td class="celda" style="border: 2px solid black; text-align: center;">{{ $index }}</td>

                <td class="celda" style="text-align: left; border: 2px solid black; text-align: center;">{{ $value['description'] }}
                    @if (isset($count['unit_type_name']))
                    <span class="small2">({{ $count['unit_type_name'] }})</span>
                    @endif
                </td>
                <td class="celda" style="border: 2px solid black; text-align: center;">
                    @if (isset($value['max_quantity_item']))
                    {{ format_unit($value, $count) }}
                    @else
                    @php
                    $c =
                    floatval($count['count']) *
                    (isset($count['factor']) ? $count['factor'] : 1);
                    @endphp
                    {{ number_format($c, 2) }}
                    @endif
                </td>
                @if (!isset($value['max_quantity_item']))
                <td class="celda" style="border: 2px solid black; text-align: center;">
                    {{ $value['unit_item'] }}
                </td>
                @endif
                @if (!$is_service)
                <td class="celda" style="border: 2px solid black; text-align: center;">{{ number_format($value['purchase_unit_price'], 2) }}</td>
                <td class="celda" style="border: 2px solid black; text-align: center;">
                    {{ number_format($price, 2) }}

                </td>
                @endif
                <td class="celda" style="border: 2px solid black; text-align: center;">{{ number_format($count['count'] * $price, 2) }}</td>
                @if (!$is_service)
                <td class="celda" style="border: 2px solid black; text-align: center;">
                    @php
                    $purchase =
                    floatval($count['count']) *
                    (isset($count['factor']) ? $count['factor'] : 1) *
                    floatval($value['purchase_unit_price']);
                    $gain = floatval($count['count'] * $price) - $purchase;
                    $gain_total += $gain;
                    @endphp

                    {{ number_format($gain, 2) }}
                </td>
                @endif
            </tr>
            @php
            $index++;
            @endphp
            @endforeach
            @endforeach

            <tr>
                @if (!$is_service)
                <td class="celda" colspan="4"></td>
                @else
                <td class="celda" colspan="3"></td>
                @endif
                <td class="celda" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Totales</td>
                <td class="celda" style="border: 2px solid black; text-align: center;">{{ number_format($total, 2) }}</td>
                @if (!$is_service)
                <td class="celda" style="border: 2px solid black; text-align: center;">{{ number_format($gain_total, 2) }}</td>
                @endif

            </tr>
        </tbody>
    </table>
    @else
    <div class="callout callout-info">
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>