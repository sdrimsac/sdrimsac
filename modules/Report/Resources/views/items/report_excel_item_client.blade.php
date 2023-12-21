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

    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td colspan="6">
                    <p><strong>Reporte de productos por cliente</strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
                <td>
                    <p><strong>Fechas: </strong>{{ $date_start }}
                        @if ($date_end)
                            - {{ $date_end }}
                        @endif
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><strong>Ruc: </strong>{{ $company->number }}</p>
                </td>
                @if ($establishment)
                    <td colspan="5">
                        <p><strong>Establecimiento: </strong>{{ $establishment->address }} -
                            {{ $establishment->department->description }} - {{ $establishment->district->description }}
                        </p>
                    </td>
                @else
                    <td colspan="3"></td>
                @endif
            </tr>
        </table>
    </div>
    @if (!empty($items))
        <div class="">
            <div class=" ">

                <table class="">
                    <thead class="thead">
                        <tr>
                            <th class="th">#</th>
                            <th colspan="5" class="th">Cliente</th>
                            <th class="th">Total</th>
                            <th class="th">Unidades</th>
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
                        // dump($items);
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
                                <td>{{ $idx + 1 }}</td>
                                <td colspan="5">{{ $customer_name }}</td>
                                <td>{{ $total }}</td>
                                <td>{{ $quantity }}</td>
                            </tr>
                            @foreach ($value as $key => $v)
                                <tr>
                                    <td></td>
                                    <td>{{ $v['total_quantity'] }}</td>
                                    <td>{{ $v['item_description'] }}</td>
                                    <td>{{ $v['series'] ."-". $v['number'] }}</td>
                                    <td>{{ $v['date_of_issue'] }}</td>
                                    <td>{{ $v['total'] }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            @endforeach
                            {{-- @foreach ($value['prices'] as $price => $count)
                                <tr>
                                    <td class="celda">{{$index}}</td>
                                    
                                    <td class="celda" style="text-align: left;">{{$value["description"]}}
                                        @if (isset($count['unit_type_name']))
                                        <span class="small2">({{$count["unit_type_name"]}})</span>
                                    @endif
                                    </td>
                                    <td class="celda">
                                        @if (isset($value['max_quantity_item']))
                                        {{format_unit($value,$count)}}
                                        @else
                                        @php
                                            $c = floatval($count["count"]) *(isset($count["factor"])?$count["factor"]:1);
                                        @endphp
                                            {{number_format($c,2)}} {{$value["unit_item"]}}
                                        @endif
                                    </td>
                                    <td class="celda">{{number_format($value["purchase_unit_price"],2)}}</td>
                                    <td class="celda">
                                        {{number_format($price,2)}}
                                        
                                    </td>
                                    <td class="celda">{{number_format($count["count"]*$price,2)}}</td>
                                    <td class="celda">
                                        @php
                                        $purchase = floatval($count["count"]) *(isset($count["factor"])?$count["factor"]:1)  * floatval($value["purchase_unit_price"]) ;
                                        $gain = floatval($count["count"]*$price) - $purchase;
                                        $gain_total +=$gain; 
                                       @endphp
                                        
                                        {{number_format($gain,2)}}</td>
                                </tr>
                                @php
                                    $index++;
                                @endphp
                                @endforeach     --}}
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
