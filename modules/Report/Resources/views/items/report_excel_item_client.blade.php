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
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid black;
        }

        .celda {
            text-align: center;
            padding: 2px;
            border: 0.1px solid black;
        }

        .th {
            padding: 2px;
            text-align: center;
            border-color: #c4c4c4;
            border: 0.1px solid black;
        }

        .title {
            font-weight: bold;
            padding: 5px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        .small2 {
            font-size: 8px;
        }

        p>strong {
            margin-left: 5px;
            font-size: 13px;
        }

        .thead {
            font-weight: bold;
            background: #c4c4c4;
            color: black;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $gain_total = 0;
    @endphp

    <table>
        <div style="margin-top:20px; margin-bottom:20px;">
            <table>
                <tr>
                    <td colspan="8"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                        <p><strong>Reporte de productos por cliente</strong></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 2px solid black;  background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{ $company->name }}</p>
                    </td>
                    <td colspan="3"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fechas: </strong>{{ $date_start }}
                            @if ($date_end)
                                - {{ $date_end }}
                            @endif
                        </p>
                    </td>
                </tr>
                <tr>
                    @if ($establishment)
                        <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                            <p><strong>Establecimiento: </strong>{{ $establishment->address }} -
                                {{ $establishment->department->description }} -
                                {{ $establishment->district->description }}
                            </p>
                        </td>
                    @else
                    @endif
                    <td colspan="3"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong>{{ $company->number }}</p>
                    </td>
                </tr>
            </table>
        </div>
        @if (!empty($items))
            <div class="">
                <div class=" ">

                    <table class="">
                        <thead class="thead">
                            <tr>
                                <th class="th"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#
                                </th>
                                <th colspan="5" class="th"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Cliente</th>
                                <th class="th"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Total</th>
                                <th class="th"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Unidades</th>
                            </tr>
                        </thead>
                        @php
                            //items to array
                            $items = json_decode(json_encode($items), true);
                            //saca de $items el "customer_id" solo los diferentes, y ordena de menor a mayor
                            $ids = array_values(array_sort(array_unique(array_column($items, 'customer_id'))));
                            $index = 1;
                            //filtra todos los items que tengan el mismo customer_id y agrupalos
                            // Función de comparación para usort
                            function sortByCustomerId($a, $b)
                            {
                                return $a['customer_id'] - $b['customer_id'];
                            }

                            // Ordenar el array por 'customer_id'
                            usort($items, 'sortByCustomerId');

                            // Agrupar por 'customer_id'
                            $groupedItems = array_reduce(
                                $items,
                                function ($result, $item) {
                                    $customerId = $item['customer_id'];
                                    $result[$customerId][] = $item;
                                    return $result;
                                },
                                [],
                            );

                            // Reindexar el array para tener índices numéricos
                            $items = array_values($groupedItems);
                        @endphp
                        <tbody>
                            @foreach ($items as $idx => $value)
                                @php

                                    $customer_name = $value[0]['customer_name'];
                                    $total = 0;
                                    $quantity = 0;
                                    foreach ($value as $key => $v) {
                                        $v_total = floatval($v['total']);
                                        $v_quantity = floatval($v['total_quantity']);
                                        $total += $v_total;
                                        $quantity += $v_quantity;
                                    }
                                @endphp
                                <tr>
                                    <td style="border: 2px solid black; text-align: center;">{{ $idx + 1 }}</td>
                                    <td colspan="5" style="border: 2px solid black; text-align: center;">
                                        {{ $customer_name }}</td>
                                    <td style="border: 2px solid black; text-align: center;">{{ $total }}</td>
                                    <td style="border: 2px solid black; text-align: center;">{{ $quantity }}</td>
                                </tr>
                                @foreach ($value as $key => $v)
                                    <tr>
                                        <td style="border: 2px solid black; text-align: center;"></td>
                                        <td style="border: 2px solid black; text-align: center;">
                                            {{ $v['total_quantity'] }}</td>
                                        <td style="border: 2px solid black; text-align: center;">
                                            {{ $v['item_description'] }}
                                            @if (!empty($v['selectedGrosor']) || !empty($v['selectedAncho']) || !empty($v['selectedLargo']))
                                                -
                                                {{ !empty($v['selectedGrosor']) ? $v['selectedGrosor'] : '' }}
                                                {{ !empty($v['selectedAncho']) ? 'x' . $v['selectedAncho'] : '' }}
                                                {{ !empty($v['selectedLargo']) ? 'x' . $v['selectedLargo'] : '' }}
                                            @endif
                                        </td>
                                        <td style="border: 2px solid black; text-align: center;">
                                            {{ $v['series'] . '-' . $v['number'] }}</td>
                                        <td style="border: 2px solid black; text-align: center;">
                                            {{ $v['date_of_issue'] }}</td>
                                        <td style="border: 2px solid black; text-align: center;">{{ $v['total'] }}
                                        </td>
                                        <td colspan="2" style="border: 2px solid black; text-align: center;"></td>
                                    </tr>
                                @endforeach
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
    </table>
@else
    <div class="callout callout-info">
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>
