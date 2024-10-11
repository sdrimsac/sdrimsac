<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    html {
        padding: 10%;
        margin: 3px;
        font-size: 10px;
    }

    table {
        width: 80%;
        border-spacing: 0;

    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .lead-font-weight-700 {
        font-weight: bold;
    }

    .border-bottom {
        border-bottom: 1px solid black;
        margin-top: 2px;
    }
</style>
@php

    function formatMoney($money)
    {
        return 'S/ ' . number_format($money, 2);
    }
@endphp
@inject('roleService', 'App\Services\RoleService')

<body>

    <div style="padding-left: 8px;">
        <div>
            <h4 class="text-center">RESUMEN DE VENTA DIARIA</h4>
        </div>
        <table class="border-bottom">
            <tr>
                <td style="border: solid 1px black;">
                    <span class="f12">ESTABLECIMIENTO:</span>
                </td>
                <td style="border: solid 1px black; width: 50%">
                    <span class="f12">{{ mb_strtoupper($establishment->description) }}</span>
                </td>
            </tr>
            <tr>
                <td style="border: solid 1px black;">
                    <span class="f12">DIRECCIÓN:</span>
                </td>
                <td style="border: solid 1px black; width: 50%">
                    <span class="f12"> {{ mb_strtoupper($establishment->address) }} </span>
                </td>
            </tr>
            <tr>
                <td style="border: solid 1px black;">
                    <span class="f12"> USUARIO: </span>
                </td>
                <td style="border: solid 1px black; width: 50%">
                    <span>{{ mb_strtoupper($user->name) }}</span>
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 " colspan="4" style="border: solid 1px black;">
                    CÓDIGO DE APERTURA:
                    {{ $cash->reference_number }}
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700  " style="border: solid 1px black;">
                    FECHA ACTUAL
                </td>
                <td class="text-left" style="border: solid 1px black; width: 50%">{{ $date }}
                    {{ $time }}</td>
            </tr>
            <tr>
                <td style="border: solid 1px black; width: 50%">
                    <span class="f12">
                        APERTURA {{ Carbon\Carbon::parse($cash->date_opening)->format('d/m/Y') }}
                        {{ $cash->time_opening }}
                    </span>
                </td>
                <td style="border: solid 1px black; width: 50%">
                    <span>
                        @if ($cash->date_closed)
                            - CIERRE
                            {{ Carbon\Carbon::parse($cash->date_closed)->format('d/m/Y') }} {{ $cash->time_closed }}
                        @endif
                    </span>

                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">
                    DINERO INICIAL
                </td>
                <td class="text-left " style="border: solid 1px black; width: 50%">
                    {{ formatMoney($cash->beginning_balance) }}
                </td>
            </tr>
            @isset($cash->difference)
                @if ($cash->difference != 0)
                    {{-- <tr>
                        <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">
                            DIFERENCIA
                        </td>
                        <td class="text-left " style="border: solid 1px black; width: 50%">
                            {{ formatMoney($cash->difference) }}
                        </td>

                    </tr>--}}
                @endif 
            @endisset
        </table>

        <table class="table border-bottom">
            <tr>
                <td class="text-left lead-font-weight-700 " colspan="4">
                    VENTAS REALIZADAS
                </td>
            </tr>
            @foreach ($sales_detail as $detail)
                @if ($detail['sum'] > 0)
                    <tr>
                        <td class="text-left lead-font-weight-700  text-uppercase" style="border: solid 1px black;">
                            {{ strtoupper($detail['desc']) }}
                        </td>
                        <td class="text-left " style="border: solid 1px black;">
                            {{ formatMoney($detail['sum']) }}

                        </td>

                        <td class="text-left" style="border: solid 1px black;">({{ $detail['quantity'] }} pagos)</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">TOTAL</td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($sales_amount) }}
                </td>
                <td class="text-left" colspan="2"></td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700 " colspan="3">
                    ARTICULOS VENDIDOS
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-left lead-font-weight-700 " style="border: solid 1px black;">ARTICULOS
                </td>

                <td class="text-left " style="border: solid 1px black;">
                    {{ $items_detail['uniques'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-left lead-font-weight-700 " style="border: solid 1px black;">UNIDADES
                </td>
                <td class="text-left " style="border: solid 1px black;"> {{ $items_detail['unds'] }}</td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700">
                    TOTAL POR CATEGORÍA
                </td>
            </tr>
            @foreach ($categories as $category => $total)
                <tr>
                    <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                        {{ $category }}</td>
                    <td class="text-right" style="border: solid 1px black;">
                        S/ {{ number_format($total, 2) }}
                    </td>
                </tr>
            @endforeach
            @if (!empty($categories))
                <tr>
                    <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">TOTAL
                    </td>
                    <td class="text-right" style="border: solid 1px black;">
                        S/ {{ number_format($totalCategory, 2) }}
                    </td>
                </tr>
            @endif
        </table>


        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700 " colspan="3">
                    ENTRADAS / SALIDAS DE EFECTIVO
                </td>
            </tr>
            <tr>
                <td class="text-left " style="border: solid 1px black;">

                    {{ $incomes_expenses_cash['incomes']['quantity'] }}
                </td>
                <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">ENTRADAS</td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($incomes_expenses_cash['incomes']['amount']) }}

                </td>
            </tr>
            <tr>
                <td class="text-left " style="border: solid 1px black;">
                    {{ $incomes_expenses_cash['expenses']['quantity'] }}
                </td>
                <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">SALIDAS</td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($incomes_expenses_cash['expenses']['amount']) }}

                </td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700 " colspan="3">
                    TOTAL CAJA
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-left lead-font-weight-700 " style="border: solid 1px black;">
                    TOTAL CAJA
                </td>

                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney(
                        $incomes_expenses_cash['incomes']['amount'] + $sales_amount - $incomes_expenses_cash['expenses']['amount'],
                    ) }}
                </td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700 " colspan="2">
                    LISTADO DE DOCUMENTOS
                </td>
            </tr>
            @foreach ($documents as $document => $amount)
                <tr>
                    <td colspan="2" class="text-left text-uppercase lead-font-weight-700 "
                        style="border: solid 1px black;">
                        {{ strtoupper($document) }}
                    </td>
                    <td class="text-left " style="border: solid 1px black;">
                        {{ formatMoney($amount) }}
                    </td>
                </tr>
            @endforeach
        </table>

        <table class="table border-bottom">
            <tr class="lead-font-weight-700">
                <td colspan="3"> CONTEO DE EFECTIVO</td>
            </tr>
            @if (is_iterable($counter))
                @foreach ($counter as $coin => $value)
                    <tr>
                        <td class="text-left lead-font-weight-700 " style="border: solid 1px black;">
                            {{ formatMoney($coin) }}
                        </td>
                        <td class="text-left " style="border: solid 1px black;">
                            {{ formatMoney($value) }}
                        </td>
                        <td class="text-left " style="border: solid 1px black;">
                            {{ formatMoney($coin * $value) }}
                        </td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td class="text-left lead-font-weight-700 ">

                </td>
                <td class="text-left " style="border: solid 1px black;">
                    TOTAL
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($total_coins) }}
                </td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    SALDO INICIAL
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($cash->beginning_balance) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    EFECTIVO
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($total_cash) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    VIRTUAL
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($total_coins_virtual) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    BANCO
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($total_coins_bank) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    GASTOS
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney($incomes_expenses_cash['expenses']['amount']) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700" style="border: solid 1px black;">
                    TOTAL
                </td>
                <td class="text-left " style="border: solid 1px black;">
                    {{ formatMoney(
                        $total_cash +
                            $total_coins_bank +
                            $total_coins_virtual +
                            $cash->beginning_balance -
                            $incomes_expenses_cash['expenses']['amount'],
                    ) }}
                </td>
            </tr>
        </table>
        {{-- @if ($roleService->isArcaUserId($user->id)) --}}
        @if ($configuration->configurable_impresion_ticket_categoria_caja)
            <div>
                <h5 class="text-center">DETALLE DE PRODUCTOS VENDIDOS </h5>
            </div>
            <table>
                @if ($grouped && count($grouped) > 0)
                    @foreach ($grouped as $category => $items)
                        <table class="border">
                            <thead>
                                <tr>
                                    <th colspan="4" class="left" style="border: solid 1px black;">
                                        <span>{{ $category }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="border: solid 1px black;"><span>UNIDAD</span></th>
                                    <th style="border: solid 1px black;"><span>DESCRIPCIÓN</span></th>
                                    <th style="border: solid 1px black;"><span>PRECIO</span></th>
                                    <th style="border: solid 1px black;"><span>TOTAL</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td class="f12 center" style="border: solid 1px black;">
                                            {{ intval($item['quantity']) }}</td>
                                        <td class="f12" style="border: solid 1px black;">
                                            {{ $item['description'] }}
                                        </td>
                                        <td class="f12 right" style="border: solid 1px black;">
                                            {{ number_format(floatval($item['price']), 2) }}</td>
                                        <td class="f12 right" style="border: solid 1px black;">
                                            {{ number_format($item['total'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td class="f12 right" style="border: solid 1px black;">TOTAL</td>
                                    <td class="f12 right" style="border: solid 1px black;">
                                        @php
                                            $total = array_reduce(
                                                $items,
                                                function ($carry, $item) {
                                                    return $carry + $item['total'];
                                                },
                                                0,
                                            );
                                        @endphp
                                        S/ {{ number_format($total, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                @endif
            </table>
        @endif
    </div>
</body>

</html>
