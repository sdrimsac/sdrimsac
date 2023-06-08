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
        width: 90%;
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

<body>

    <div style="padding-left: 8px;">
        <table class="border-bottom">
            <tr>
                <td class="text-left lead-font-weight-700 " colspan="4">
                    CÓDIGO DE APERTURA:
                    {{ $cash->reference_number }}
                </td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 ">
                    FECHA ACTUAL
                </td>
                <td class="text-left  ">{{ $date }}</td>
                <td class="text-left lead-font-weight-700 ">
                    HORA ACTUAL
                </td>
                <td class="text-left ">{{ $time }}</td>
            </tr>
            <tr>
                <td class="text-left lead-font-weight-700 ">
                    APERTURA
                </td>
                <td class="text-left ">
                    {{ formatMoney($cash->opening) }}
                </td>
                <td class="text-left lead-font-weight-700 ">
                    DINERO INICIAL
                </td>
                <td class="text-left ">
                    {{ formatMoney($cash->beginning_balance) }}
                </td>
            </tr>
            @isset($cash->difference)
                @if ($cash->difference != 0)
                    <tr>
                        <td class="text-left lead-font-weight-700 ">
                            DIFERENCIA
                        </td>
                        <td class="text-left ">
                            {{ formatMoney($cash->difference) }}
                        </td>

                    </tr>
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
                        <td class="text-left lead-font-weight-700  text-uppercase">
                            {{ strtoupper($detail['desc']) }}
                        </td>
                        <td class="text-left ">
                            {{ formatMoney($detail['sum']) }}

                        </td>

                        <td class="text-left ">({{ $detail['quantity'] }} pagos)</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td class="text-left lead-font-weight-700 ">TOTAL</td>
                <td class="text-left ">
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
                <td colspan="2" class="text-left lead-font-weight-700 ">ARTICULOS</td>

                <td class="text-left ">
                    {{ $items_detail['uniques'] }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-left lead-font-weight-700 ">UNIDADES</td>
                <td class="text-left "> {{ $items_detail['unds'] }}</td>
            </tr>
        </table>

        <table class="table border-bottom">
            <tr>
                <td colspan="3" class="text-left lead-font-weight-700 " colspan="3">
                    ENTRADAS / SALIDAS DE EFECTIVO
                </td>
            </tr>
            <tr>
                <td class="text-left ">

                    {{ $incomes_expenses_cash['incomes']['quantity'] }}
                </td>
                <td class="text-left lead-font-weight-700 ">ENTRADAS</td>
                <td class="text-left ">
                    {{ formatMoney($incomes_expenses_cash['incomes']['amount']) }}

                </td>
            </tr>
            <tr>
                <td class="text-left ">
                    {{ $incomes_expenses_cash['expenses']['quantity'] }}
                </td>
                <td class="text-left lead-font-weight-700 ">SALIDAS</td>
                <td class="text-left ">
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
                <td colspan="2" class="text-left lead-font-weight-700 ">
                    TOTAL CAJA
                </td>

                <td class="text-left ">
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
                    <td colspan="2" class="text-left text-uppercase lead-font-weight-700 ">
                        {{ strtoupper($document) }}
                    </td>
                    <td class="text-left ">
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
                        <td class="text-left lead-font-weight-700 ">
                            {{ formatMoney($coin) }}
                        </td>
                        <td class="text-left ">
                            {{ formatMoney($value) }}
                        </td>
                        <td class="text-left ">
                            {{ formatMoney($coin * $value) }}
                        </td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td class="text-left lead-font-weight-700 ">

                </td>
                <td class="text-left ">
                    TOTAL
                </td>
                <td class="text-left ">
                    {{ formatMoney($total_coins) }}
                </td>
            </tr>
        </table>

        <table class="table border-bottom">

            <tr>

                <td colspan="2" class="text-left lead-font-weight-700">
                    EFECTIVO
                </td>
                <td class="text-left ">
                    {{ formatMoney($total_coins) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700">
                    VIRTUAL
                </td>
                <td class="text-left ">
                    {{ formatMoney($total_coins_virtual) }}
                </td>
            </tr>
            <tr>

                <td colspan="2" class="text-left lead-font-weight-700">
                    TOTAL
                </td>
                <td class="text-left ">
                    {{ formatMoney($total_coins + $total_coins_virtual) }}
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
