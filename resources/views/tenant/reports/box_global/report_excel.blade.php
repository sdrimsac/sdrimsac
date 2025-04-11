<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte global</title>
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
for ($i = 0; $i < count($columns); $i++) { $total +=calculateSum($cash, $columns[$i]); } return $total; } } if (!function_exists('calculateSum')) { function calculateSum($cash, $column) { return array_reduce( $cash->toArray(),
    function ($sum, $item) use ($column) {
    return $sum + floatval(getValueColumn($column, $item));
    },
    0,
    );
    }
    $totals = [];
    for ($i = 0; $i < count($columns); $i++) { $column=$columns[$i]; $total=array_reduce( $records, function ($sum, $record) use ($column) { return $sum + calculateSum($record['cash'], $column); }, 0, ); $totals[]=$total; } } @endphp <body>
        <table>
            <tr>
                <td class="text-end" colspan="6" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 15px; font-weight: bold;">
                    <h3>Reporte global De Caja</h3>
                </td>
            </tr>
            <tr>
                <td class="text-end" colspan="6" style="border: 2px solid black; background-color: #DCDCDC; font-size: 13px;">
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
            </tr>
            <tr>
                <td class="text-end" colspan="4" style="border: 2px solid black; background-color: #DCDCDC; font-size: 13px;">
                    <p><strong>Ruc: </strong>{{ $company->number }}</p>
                </td>
                <td class="text-end" colspan="2" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                    <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                </td>
                <!-- <td align="center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">{{ $company->number }}</td> -->
                <!-- <td class="text-end"></td>
                <td align="center"></td> -->
            </tr>

            @if (!empty($records))
            @php
            $length_columns = count($columns);
            @endphp
            @foreach ($records as $key => $value)
            @php
            $record = (object) $value;
            @endphp

            <thead>
                <tr>
                    <th class="text-end" colspan="{{ $length_columns + 2 }}" style="border: 2px solid black; background-color: #d6e4ed; font-weight: bold; font-size: 12px;">
                        {{ $record->establishment_description }}
                    </th>
                </tr>
                @if (count($record->cash) != 0)
                <tr>
                    <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;"></th>
                    @foreach ($columns as $column)
                    <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-weight: bold;">{{ strtoupper($column) }}</th>
                    @endforeach
                    <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-weight: bold;">TOTAL</th>
                </tr>
                @endif
            </thead>
            <tbody>
                @foreach ($record->cash as $item)
                <tr>
                    <td class="text-end" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                        {{ $item['turn'] }}
                    </td>
                    @foreach ($columns as $column)
                    <td class="text-end" style="border: 2px solid black; text-align: center;">
                        {{ getValueColumn($column, $item) }}
                    </td>
                    @endforeach
                    <td class="text-end" style="border: 2px solid black; text-align: center; ">
                        {{ calculateSumEstablishment($item) }}
                    </td>


                </tr>
                @endforeach
                @if (count($record->cash) != 0)
                <tr>

                    <td class="text-end" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                        <strong>
                            SUBTOTAL
                        </strong>
                    </td>
                    @foreach ($columns as $column)
                    <td class="text-end" style="border: 2px solid black; text-align: center;">
                        {{ calculateSum($record->cash, $column) }}
                    </td>
                    @endforeach
                    <td class="text-end" style="border: 2px solid black; text-align: center;">
                        {{ calculateSumRow($record->cash,$columns) }}
                    </td>
                </tr>
                @endif
            </tbody>

            @endforeach
            @if (count($records) != 0)

            <tr>
                <td class="text-end" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                    <strong>
                        TOTAL GENERAL
                    </strong>
                </td>
                @foreach ($totals as $total)
                <td class="text-end" style="border: 2px solid black; text-align: center; ;">
                    {{ $total }}
                </td>
                @endforeach
                <td class="text-end" style="border: 2px solid black; text-align: center;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                    <strong>
                        TOTAL VENTA ACUMULADA
                    </strong>
                </td>
                <td class="text-end" style="border: 2px solid black; text-align: center; ">
                    @php
                    $sum_totals = array_sum($totals);
                    @endphp
                    {{ $sum_totals }}
                </td>
                <td colspan="{{ $length_columns - 1 }}" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;"></td>

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