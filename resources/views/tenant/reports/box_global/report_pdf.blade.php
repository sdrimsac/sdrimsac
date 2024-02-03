<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte global</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0 15px;
            padding: 0;
        }

        .table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .celda {
            text-align: center;
            padding: 2px;
            border: 0.1px solid black;
        }
        .table td{
            padding: 2px;
            text-align: left;
            border-color: #bebebe;
            border: 0.1px solid black;
        }

        th {
            padding: 2px;
            text-align: left;
            border-color: #bebebe;
            border: 0.1px solid black;
        }

        .title {
            font-weight: bold;
            /* padding: 5px; */
            font-size: 20px !important;
            text-decoration: underline;
        }

        p>strong {
            margin-left: 5px;
            font-size: 13px;
        }
       .table td.text-end{
            text-align: right;
        }

        thead {
            font-weight: bold;
            background: #555555;
            color: white;
            text-align: left;
        }
    </style>
</head>
@php
    
    if (!function_exists('getValueColumn')) {
        function getValueColumn($column, $item)
        {
            $records = $item['records'];
    
            $methodMap = array_reduce(
                $records,
                function ($map, $record) {
                    $map[$record['method']] = $record['amount'];
                    return $map;
                },
                [],
            );
    
            $amount = $methodMap[$column] ?? 0;
    
            return $amount;
        }
    }
    
    if (!function_exists('calculateSumEstablishment')) {
        function calculateSumEstablishment($item)
        {
            $records = $item['records'];
            $sum = array_reduce(
                $records,
                function ($sum, $item) {
                    return $sum + floatval($item['amount']);
                },
                0,
            );
            return $sum;
        }
    }
    if (!function_exists('calculateSumRow')) {
        function calculateSumRow($cash,$columns)
        {
            $total = 0;
            for ($i = 0; $i < count($columns); $i++) {
                $total += calculateSum($cash, $columns[$i]);
            }
            return $total;
        }
    }
    if (!function_exists('calculateSum')) {
        function calculateSum($cash, $column)
        {
            return array_reduce(
                $cash->toArray(),
                function ($sum, $item) use ($column) {
                    return $sum + floatval(getValueColumn($column, $item));
                },
                0,
            );
        }
        $totals = [];
        for ($i = 0; $i < count($columns); $i++) {
            $column = $columns[$i];
            $total = array_reduce(
                $records,
                function ($sum, $record) use ($column) {
                    return $sum + calculateSum($record['cash'], $column);
                },
                0,
            );
            $totals[] = $total;
        }
    }
@endphp

<body>
    <div>
        <h3 align="center" class="title"><strong>Reporte global</strong></h3>
    </div>
    <br>
    <div style="">
        <table>

            <tr>
                <td class="text-end">
                    <p><b>Empresa: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $company->name }}</strong></p>
                </td>
                <td class="text-end">
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
                <td>{{ $company->number }}</td>
                <td class="text-end">
                </td>
                <td align="center">

                </td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        @php
            $length_columns = count($columns);
        @endphp
        @foreach ($records as $key => $value)
            @php
                $record = (object) $value;
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="{{ $length_columns + 2 }}">
                            {{ $record->establishment_description }}
                        </th>
                    </tr>
                    @if (count($record->cash) != 0)
                        <tr>
                            <th></th>
                            @foreach ($columns as $column)
                                <th>{{ strtoupper($column) }}</th>
                            @endforeach
                            <th>TOTAL</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @foreach ($record->cash as $item)
                        <tr>
                            <td width="8%" class="text-end">
                                {{ $item['turn'] }}
                            </td>
                            @foreach ($columns as $column)
                                <td 
                                width="{{ 84 / $length_columns }}%"
                                class="text-end">
                                    {{ getValueColumn($column, $item) }}
                                </td>
                            @endforeach
                            <td width="8%" class="text-end">
                                {{ calculateSumEstablishment($item) }}
                            </td>


                        </tr>
                    @endforeach
                    @if (count($record->cash) != 0)
                        <tr>

                            <td class="text-end">
                                <strong>
                                    SUBTOTAL
                                </strong>
                            </td>
                            @foreach ($columns as $column)
                                <td class="text-end">
                                    {{ calculateSum($record->cash, $column) }}
                                </td>
                            @endforeach
                            <td class="text-end">
                                {{ calculateSumRow($record->cash,$columns) }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
        @if (count($records) != 0)
            <table class="table">
                <tr>
                    <td class="text-end" width="8%">
                        <strong>
                            TOTAL GENERAL
                        </strong>
                    </td>
                    @foreach ($totals as $total)
                        <td 
                        width="{{ 84 / $length_columns }}%"
                        class="text-end">
                            {{ $total }}
                        </td>
                    @endforeach
                    <td class="text-end" width="8%"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>
                            TOTAL VENTA DEL DIA
                        </strong>
                    </td>
                    <td class="text-end">
                        @php
                            $sum_totals = array_sum($totals);
                        @endphp
                        {{ $sum_totals }}
                    </td>
                    <td colspan="{{ $length_columns - 1 }}"></td>

                </tr>
            </table>
        @endif
    @else
        <div>
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
