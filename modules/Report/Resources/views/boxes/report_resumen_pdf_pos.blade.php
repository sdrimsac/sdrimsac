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
            font-size: 11px;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        .table {
            border: 0.1px solid #ccc;
        }

        .celda {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_center {
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_right {
            text-align: right;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_left {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        tr:nth-child(even) {}

        .nth-child {
            background-color: transparent;
        }

        .border-bottom {
            border-bottom: 0.1px solid #ccc;
        }

        td {}

        th {
            padding: 5px;
            text-align: center;

        }

        .headers {
            padding: 5px !important;
            border-bottom: 0.1px solid #ccc;
            height: 25px;
            font-size: 14px !important;
        }

        .title {
            font-weight: bold;
            padding: 5px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        p>strong {
            margin-left: 5px;
            font-size: 13px;
        }

        thead {
            font-weight: bold;
            color: #000;
            text-align: center;
        }

        .title {
            font-weight: bold;
            padding: 3px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        .encabezado {
            background-color: #ccc;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 10px;
        }

        .categoria {
            background-color: #eee;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 50px;
        }

        .celda_loop {
            width: 10% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_descrip {
            width: 60% !important;
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_date {
            width: 30% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        p>strong {
            margin-left: 5px;
            font-size: 11px;
        }

        header {
            position: fixed;
            height: 1cm;
            color: #000;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            font-family: arial;

        }

        footer {
            position: fixed;
            bottom: 10px;
            height: 0.8cm;
            color: #000;
            text-align: center;
            font-size: 11px;
            padding: 12px;
            font-family: Arial;
            padding: 10px;
        }

        @page {
            margin: 0.1cm 0.1cm 0.1cm 0.1cm;
            font-family: sans-serif;
        }

        td {}

        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }

        body {
            margin: 1cm 0.1cm 0.1cm 0.1cm;
        }

        .f12 {
            font-size: 12px !important;
        }

        .f15 {
            font-size: 15px !important;
        }

        .f18 {
            font-size: 18px !important;
        }

        .left {
            text-align: left !important;
        }

        .right {
            text-align: right !important;
        }

        .center {
            text-align: center !important;
        }

        .border {
            border: 1px solid black;
        }

        .border td,
        .border th {
            border: 1px solid black;
        }

        .bold {
            font-weight: bold;
        }

        .thead {
            color: white;
            background-color: rgb(21, 21, 113)
        }
    </style>
</head>
@php
    $digital = $total_coins_virtual;
    $transfer = $total_coins_transfert;
    function get_coin($coin, $counter)
    {
        if (array_key_exists($coin, $counter)) {
            return [
                'quantity' => $counter[$coin],
                'total' => number_format(floatval($counter[$coin]) * floatval($coin), 2),
            ];
        }
        return [
            'quantity' => 0,
            'total' => '-',
        ];
    }
    
@endphp

<body>
    <header>
        <table style="border-collapse: collapse;border-bottom:1px solid #ddd;border:0px !important; ">
            <tr>

                <td width="50%" height="30" align="right" valign="middle"
                    style="font-size:13px !important;  font-family: sans-serif !important;border-bottom:1px solid #ccc">
                    Arqueo de Caja {{ \Carbon\Carbon::parse($cash->date_opening)->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </header>
    <div style="margin: 0px;">
        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse; ">
            <tr>
                @if ($establishment->logo || $establishment->document_logo)
                    <td width="50%">
                        <div>
                            @if ($establishment->document_logo)
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$establishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$establishment->document_logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo"
                                    style="width: 200px; height:80px;">
                            @else
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$establishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$establishment->logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo"
                                    style="width: 200px; height:80px;">
                            @endif
                        </div>
                    </td>
                @else
                    @if ($company->logo)
                        <td width="50%">
                            <div>
                                @if ($company->document_logo)
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                        alt="{{ $company->trade_name }}" class="company_logo"
                                        style="width: 200px; height:80px;">
                                @else
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                        alt="{{ $company->trade_name }}" class="company_logo"
                                        style="width: 200px; height:80px;">
                                @endif
                            </div>
                        </td>
                    @else
                        <td width="50%">
                            {{-- <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px"> --}}
                        </td>
                    @endif
                @endif
                {{-- <td width="50%">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/LEGO_logo.svg/500px-LEGO_logo.svg.png"
                        alt="logo" style="width: 200px; height:80px;">

                </td> --}}
                <td width="50%" style="vertical-align: top;text-align: right">
                    <div>
                        <span style="font-size: 25px !important;font-weight: bold">RESUMEN DE VENTA DIARIA</span>
                    </div>
                    <div>

                        <span style="font-size: 15px !important;">CODIGO DE APERTURA:
                            {{ $cash->reference_number }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%" style="vertical-align: top;text-align: left">
                    <span class="f12">ESTABLECIMIENTO: {{ mb_strtoupper($establishment->description) }}</span>
                </td>
                <td width="50%" style="vertical-align: top;text-align: right">
                    <span class="f12">
                        APERTURA {{ Carbon\Carbon::parse($cash->date_opening)->format('d/m/Y') }}
                        {{ $cash->time_opening }}
                        @if ($cash->date_closed)
                            - CIERRE
                            {{ Carbon\Carbon::parse($cash->date_closed)->format('d/m/Y') }} {{ $cash->time_closed }}
                        @endif
                    </span>
                </td>
            </tr>

        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td width="60%">
                    <div>
                        <span class="f12">DIRECCIÓN:{{ mb_strtoupper($establishment->address) }}</span>
                    </div>
                    <div>
                        <span class="f12"> USER:
                            {{ mb_strtoupper($user->name) }}
                        </span>
                    </div>
                    <table>
                        <tr>
                            <td width="58%">
                                <table class="border">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="text-align: center;" class="thead">
                                                <span class="f12">
                                                    LISTADO DE DOCUMENTOS
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="f12">{{ $documents['facturas']['quantity'] }}</span>
                                            </td>
                                            <td><span class="f12">FACTURAS</span></td>
                                            <td class="right"><span class="f12 right">
                                                    {{ number_format($documents['facturas']['total'], 2) }}
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="f12">{{ $documents['boletas']['quantity'] }}</span>
                                            </td>
                                            <td><span class="f12">BOLETAS</span></td>
                                            <td class="right"><span class="f12 right">
                                                    {{ number_format($documents['boletas']['total'], 2) }}
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="f12">{{ $documents['notas']['quantity'] }}</span>
                                            </td>
                                            <td><span class="f12">NOTAS</span></td>
                                            <td class="right"><span class="f12">
                                                    {{ number_format($documents['notas']['total'], 2) }}
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="f12">{{ $documents['recibos']['quantity'] }}</span>
                                            </td>
                                            <td><span class="f12">RECIBOS</span></td>
                                            <td class="right"><span class="f12">
                                                    {{ number_format($documents['recibos']['total'], 2) }}
                                                </span></td>
                                        </tr>
                                        <tr>
                                            <td class="right" colspan="3">
                                                <span class="f12">
                                                    S/
                                                    {{ number_format($documents['facturas']['total'] + $documents['boletas']['total'] + $documents['notas']['total'] + $documents['recibos']['total'], 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="42%" style="vertical-align: top">
                                <table class="border">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center;" class="thead">
                                                <span class="f12">
                                                    E/SALIDAS DE EFECTIVO
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="f12">INGRESO</span></td>
                                            <td class="right"><span
                                                    class="f12 right">{{ number_format($incomes_expenses_cash['incomes']['amount'], 2) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="f12">SALIDA</span></td>
                                            <td class="right"><span class="f12 right">
                                                    {{ number_format($incomes_expenses_cash['expenses']['amount'], 2) }}</span>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%" style="vertical-align: top">
                    <table class="border f12">
                        <tr>
                            <td>
                                <span class="f12">SALDO DE APERTURA</span>
                            </td>
                            <td class="right">
                                <span class="f12">{{ number_format($cash->beginning_balance, 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="f12">VENTAS EFECTIVO</span>
                            </td>
                            <td class="right">
                                <span class="f12"> {{ number_format($sales_detail['cash']['sum'], 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="f12">VENTAS DIGITAL</span>
                            </td>
                            <td class="right">
                                <span class="f12">
                                    {{ number_format(round($digital * 10) / 10, 2) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="f12">TRANSFERENCIAS</span>
                            </td>
                            <td class="right">
                                <span class="f12">
                                    {{ number_format(round($transfer * 10) / 10, 2) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="f12">INGRESO EFECTIVO</span>
                            </td>
                            <td class="right">
                                <span class="f12">
                                    {{ number_format($incomes_expenses_cash['incomes']['amount'], 2) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="f12">SALIDA EFECTIVO</span>
                            </td>
                            <td class="right">
                                <span class="f12" style="color: red">
                                    {{ number_format($incomes_expenses_cash['expenses']['amount'], 2) }}

                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="f12">TOTAL CIERRE</span>
                            </td>
                            <td class="right">
                                @php
                                    $total_cierre = $transfer + $digital + $sales_detail['cash']['sum'] + $cash->beginning_balance + $incomes_expenses_cash['incomes']['amount'] - $incomes_expenses_cash['expenses']['amount'];
                                @endphp
                                <span class="f12">S/ {{ number_format($total_cierre, 2) }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="35%">
                    @if ($total_discount > 0)
                        <table class="border f12">
                            <thead>
                                <tr class="thead">
                                    <th colspan="4">
                                        <span class="f12">TOTAL DESCUENTOS</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="center">
                                        <span class="f12 bold">S/ {{ number_format($total_discount, 2) }}</span>

                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    @endif
                    <table class="border f12">
                        <thead>
                            <tr class="thead">
                                <th colspan="4">
                                    <span class="f12">ARTICULOS VENDIDOS</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="center">
                                    <span class="f12 bold">ARTICULOS</span>
                                    <span class="f12">{{ $items_detail['uniques'] }}</span>
                                    <span class="f12 bold">UND</span>
                                    <span class="f12">{{ $items_detail['unds'] }}</span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </td>
                <td width="65%" style="text-align: right;">
                    <span style="font-size:20px !important;">EFECTIVO : S/.</span>
                    <span style="font-size:20px !important; color: blue;">
                        {{ number_format(
                            $cash->beginning_balance +
                                $sales_detail['cash']['sum'] -
                                $incomes_expenses_cash['expenses']['amount'] +
                                $incomes_expenses_cash['incomes']['amount'],
                            2,
                        ) }}
                    </span>
                    @isset($difference)
                        @if ($difference != 0)
                            <br>
                            <span
                                style="font-size:20px !important;@if ($difference < 0) color: red;@else color:blue; @endif">
                                DIFERENCIA DE CONTEO
                                {{ number_format($difference - $cash->final_balance + $cash->beginning_balance, 2) }}
                            </span>
                        @endif
                    @endisset
                </td>
            </tr>
        </table>
        <table style="margin-top: 10px;">
            <tr>
                <td width="35%" style="vertical-align: top">
                    <div>
                        <br>
                    </div>
                    <table class="border" style="margin-top:4px;">
                        <thead>
                            <tr>
                                <th class="thead" colspan="3">
                                    <span class="f12">VENTAS POR METODOS DE PAGO</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_detail as $detail)
                                @if ($detail['sum'] > 0)
                                    <tr>
                                        <td class="f12">{{ $detail['quantity'] }}</td>
                                        <td class="f12">{{ strtoupper($detail['desc']) }}</td>
                                        <td class="f12 right">{{ number_format($detail['sum'], 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach


                        </tbody>
                    </table>
                </td>
                <td width="65%">
                    <div>
                        <span class="f12">
                            CONTEO DE DINERO
                        </span>
                    </div>
                    <table>

                        <tr>
                            <td width="50%" style="vertical-align: top">
                                <table class="border">
                                    <thead>
                                        <tr class="thead">
                                            <th>
                                                <span class="f12">DEN</span>
                                            </th>
                                            <th>
                                                <span class="f12">
                                                    CANT
                                                </span>
                                            </th>
                                            <th>
                                                <span class="f12">
                                                    S. TOTAL
                                                </span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $part_1 = ['0.1', '0.2', '0.5', '1', '2', '5'];
                                        @endphp
                                        @foreach ($part_1 as $coin)
                                            <tr>
                                                <td>
                                                    <span class="f12">{{ $coin }}</span>
                                                </td>
                                                <td class="center">
                                                    <span
                                                        class="f12">{{ get_coin($coin, $counter)['quantity'] }}</span>
                                                </td>
                                                <td class="center">
                                                    <span
                                                        class="f12">{{ get_coin($coin, $counter)['total'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </td>
                            <td width="50%">
                                <table class="border">
                                    <thead>
                                        <tr class="thead">
                                            <th>
                                                <span class="f12">DEN</span>
                                            </th>
                                            <th>
                                                <span class="f12">
                                                    CANT
                                                </span>
                                            </th>
                                            <th>
                                                <span class="f12">
                                                    S. TOTAL
                                                </span>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $part_2 = ['10', '20', '50', '100', '200'];
                                        @endphp
                                        @foreach ($part_2 as $coin)
                                            <tr>
                                                <td>
                                                    <span class="f12">{{ $coin }}</span>
                                                </td>
                                                <td class="center">
                                                    <span
                                                        class="f12">{{ get_coin($coin, $counter)['quantity'] }}</span>
                                                </td>
                                                <td class="center">
                                                    <span
                                                        class="f12">{{ get_coin($coin, $counter)['total'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td class="right" colspan="3">
                                                <span class="f12">TOTAL CONTEO S/
                                                    {{ number_format($total_coins, 2) }}</span>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        @if (!empty($datosSeries))

            <table style="margin-top: 10px;"> {{-- visualizacion de ventas por series  --}}
                <tr>
                    <td width="50%" style="vertical-align: top">
                        <div>
                            <br>

                        </div>
                        <table class="border" style="margin-top:4px;">
                            <thead>
                                <tr>
                                    <th class="thead" colspan="4">
                                        <span class="f12">DETALLE SERIES VENDIDAS</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="thead">
                                        <span class="f12">#</span>
                                    </th>
                                    <th class="thead">
                                        <span class="f12">DOCUMENTO</span>
                                    </th>
                                    <th class="thead">
                                        <span class="f12">PRODUCTO</span>
                                    </th>
                                    <th class="thead">
                                        <span class="f12">SERIE</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($datosSeries as $index => $detailseries)
                                    <tr>
                                        <td width="10%" class="f12 center">{{ $index + 1 }}</td>
                                        <td width="10%" class="f12 center">{{ $detailseries[0] }}</td>
                                        <td width="70%" class="f12">{{ strtoupper($detailseries[1]) }}</td>
                                        <td width="35%" class="f12 right">{{ $detailseries[2] }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </td>

                </tr>
            </table>
        @endif

        <table style="margin-top:10px;">
            <td width="50%">
                <div style="text-align:center;">
                    <span style="font-size: 18px !important; font-weight: bold;">
                        DETALLE DE GASTO
                    </span>
                </div>
                <table class="border">
                    <thead>

                        <tr>
                            <th>
                                <span class="f12">
                                    ITEM
                                </span>
                            </th>
                            <th>
                                <span class="f12">
                                    DESCRIPCIÓN
                                </span>
                            </th>
                            <th>
                                <span class="f12">
                                    TOTAL
                                </span>
                            </th>
                        </tr>
                    </thead>
                    @if (count($expenses_records) == 0)
                        <tbody>
                            <tr>
                                <td colspan="3" class="center">
                                    <span class="f12">Sin gastos</span>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>

                            @foreach ($expenses_records as $expense)
                                <tr>
                                    <td>
                                        <span class="f12">
                                            {{ $expense['items'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="f12">
                                            {{ $expense['description'] }}
                                        </span>
                                    </td>
                                    <td class=" right">
                                        <span class="f12">
                                            {{ $expense['amount'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" class="right">
                                    <span class="f12">S/
                                        {{ number_format($incomes_expenses_cash['expenses']['amount'], 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </td>
            <td width="50%">
                <div style="text-align:center;">
                    <span style="font-size: 18px !important; font-weight: bold;">
                        DETALLE DE INGRESO
                    </span>
                </div>
                <table class="border">
                    <thead>

                        <tr>

                            <th>
                                <span class="f12">
                                    DESCRIPCIÓN
                                </span>
                            </th>
                            <th>
                                <span class="f12">
                                    TOTAL
                                </span>
                            </th>
                        </tr>
                    </thead>
                    @if (count($incomes_records) == 0)
                        <tbody>
                            <tr>
                                <td colspan="3" class="center">
                                    <span class="f12">Sin ingresos</span>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>

                            @foreach ($incomes_records as $income)
                                <tr>

                                    <td>
                                        <span class="f12">
                                            {{ $income['description'] }}
                                        </span>
                                    </td>
                                    <td class=" right">
                                        <span class="f12">
                                            {{ $income['amount'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" class="right">
                                    <span class="f12">S/
                                        {{ number_format($incomes_expenses_cash['incomes']['amount'], 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </td>
        </table>
        @if ($all_credit_documents && count($all_credit_documents) > 0)
            <table style="margin-top: 10px;" class="border">
                <thead>
                    <tr>
                        <th colspan="9">
                            <span class="f12">
                                CREDITOS Y PAGOS
                            </span>
                        </th>
                    </tr>
                    <tr>
                        <th class="center">FECHA</th>
                        <th class="center">HORA</th>
                        <th class="center">NRO DOC</th>
                        <th class="center">DNI/RUC</th>
                        <th class="center">CLIENTE</th>
                        <th class="center">METODO DE PAGO</th>
                        <th class="center">MONTO PAGADO</th>
                        <th class="center">ESTADO</th>
                        <th class="center">PAGO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_credit_documents as $credit_document)
                        <tr>
                            <td>
                                {{ $credit_document['date'] }}
                            </td>
                            <td>
                                {{ $credit_document['time'] }}

                            </td>
                            <td>
                                {{ $credit_document['number'] }}
                            </td>
                            <td>
                                {{ $credit_document['customer_number'] }}
                            </td>
                            <td>
                                {{ $credit_document['customer_name'] }}
                            </td>
                            <td>
                                {{ $credit_document['method'] }}
                            </td>
                            <td>
                                {{ $credit_document['amount'] }}
                            </td>
                            <td>
                                {{ $credit_document['paid'] ? 'CANCELADO' : 'DEBE' }}
                            </td>
                            <td>
                                {{ $credit_document['paid'] ? '0.00' : $credit_document['remaining'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if ($all_credit_items && count($all_credit_items) > 0)
            <div style="text-align:center;">
                <table >
                    <thead>
                        <tr>
                            <th colspan="4">
                               <span class="f12">
                                PRODUCTOS DADOS A CRÉDITO
                               </span>
                            </th>
                        </tr>
                    </thead>
                </table>

                @foreach ($all_credit_items as $group)
                    <table class="border">
                        <thead>
                            <tr>
                                <th colspan="4" class="left">
                                    <span class="f12">
                                        {{ $group[0]['category'] }}
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="f12">UNIDAD</span>
                                </th>
                                <th>
                                    <span class="f12">DESCRIPCION</span>
                                </th>
                                <th>
                                    <span class="f12">PRECIO</span>
                                </th>
                                <th>
                                    <span class="f12">TOTAL</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group as $a_item)
                                <tr>
                                    <td class="f12 center">
                                        {{ intval($a_item['quantity']) }}
                                    </td>
                                    <td class="f12">
                                        {{ $a_item['description'] }}
                                    </td>
                                    <td class="f12 right">
                                        {{ number_format(floatval($a_item['price']), 2) }}
                                    </td>
                                    <td class="f12 right">
                                        {{ number_format($a_item['total'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td class="f12 right">TOTAL</td>
                                <td class="f12 right">
                                    @php
                                        $t = array_reduce(
                                            $group,
                                            function ($carry, $item) {
                                                return $carry + $item['total'];
                                            },
                                            0,
                                        );
                                    @endphp
                                    S/ {{ number_format($t, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach

            </div>
        @endif
        @if ($grouped && count($grouped) > 0)
            <div style="text-align:center;">
                <span style="font-size: 18px !important;">
                    DETALLE DE PRODUCTOS VENDIDOS
                </span>

                @foreach ($grouped as $group)
                    <table class="border">
                        <thead>
                            <tr>
                                <th colspan="4" class="left">
                                    <span class="f12">
                                        {{ $group[0]['category'] }}
                                    </span>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <span class="f12">UNIDAD</span>
                                </th>
                                <th>
                                    <span class="f12">DESCRIPCION</span>
                                </th>
                                <th>
                                    <span class="f12">PRECIO</span>
                                </th>
                                <th>
                                    <span class="f12">TOTAL</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($group as $a_item)
                                <tr>
                                    <td class="f12 center">
                                        {{ intval($a_item['quantity']) }}
                                    </td>
                                    <td class="f12">
                                        {{ $a_item['description'] }}
                                    </td>
                                    <td class="f12 right">
                                        {{ number_format(floatval($a_item['price']), 2) }}
                                    </td>
                                    <td class="f12 right">
                                        {{ number_format($a_item['total'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"></td>
                                <td class="f12 right">TOTAL</td>
                                <td class="f12 right">
                                    @php
                                        $t = array_reduce(
                                            $group,
                                            function ($carry, $item) {
                                                return $carry + $item['total'];
                                            },
                                            0,
                                        );
                                    @endphp
                                    S/ {{ number_format($t, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach

            </div>
        @endif
        {{-- <table>
            <thead>
                <tr>
                    <th colspan="2">
                        <div style="text-align:center;">
                            <span style="font-size: 18px !important;">
                                DETALLE DE PRODUCTOS VENDIDOS
                            </span>
                        </div>

                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_elements = array_reduce(
                        $grouped,
                        function ($carry, $item) {
                            return $carry + count($item);
                        },
                        0,
                    );
                    $arr = [];
                    $arr2 = [];
                    $sum = intval($total_elements / 2);
                    if (count($grouped) != 2) {
                        foreach ($grouped as $group) {
                            $sum1 = array_reduce(
                                $arr,
                                function ($carry, $item) {
                                    return $carry + count($item);
                                },
                                0,
                            );
                    
                            if ($sum1 <= $sum) {
                                array_push($arr, $group);
                            } else {
                                array_push($arr2, $group);
                            }
                        }
                    } else {
                        $arr[] = $grouped[0];
                        $arr2[] = $grouped[1];
                    }
                    
                    $general = [$arr, $arr2];
                    
                @endphp
                <tr>
                    @foreach ($general as $arrr)
                        <td width="50%" style="vertical-align: top">
                            @foreach ($arrr as $a)
                                <table class="border">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="left">
                                                <span class="f12">
                                                    {{ $a[0]['category'] }}
                                                </span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                <span class="f12">UNIDAD</span>
                                            </th>
                                            <th>
                                                <span class="f12">DESCRIPCION</span>
                                            </th>
                                            <th>
                                                <span class="f12">PRECIO</span>
                                            </th>
                                            <th>
                                                <span class="f12">TOTAL</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($a as $a_item)
                                            <tr>
                                                <td class="f12 center">
                                                    {{ intval($a_item['quantity']) }}
                                                </td>
                                                <td class="f12">
                                                    {{ $a_item['description'] }}
                                                </td>
                                                <td class="f12 right">
                                                    {{ number_format(floatval($a_item['price']), 2) }}
                                                </td>
                                                <td class="f12 right">
                                                    {{ number_format($a_item['total'], 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="f12 right">TOTAL</td>
                                            <td class="f12 right">
                                                @php
                                                    $t = array_reduce(
                                                        $a,
                                                        function ($carry, $item) {
                                                            return $carry + $item['total'];
                                                        },
                                                        0,
                                                    );
                                                @endphp
                                                S/ {{ number_format($t, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            @endforeach

                        </td>
                    @endforeach


                </tr>

            </tbody>
        </table> --}}
    </div>

    {{-- <table>
        <tbody>
            <tr>
                <td>
                    <span>Titulo</span>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <table>

                                <tr>
                                    <table style="margin-top:10px;">
                                        <thead>
                                            <tr>CATEGORIA A </tr>
                                            <tr>
                                                <th>
                                                    <span class="f12">UNID</span>

                                                </th>
                                                <th>
                                                    <span class="f12">DESCR</span>

                                                </th>
                                                <th>
                                                    <span class="f12">PRECIO</span>

                                                </th>
                                                <th>
                                                    <span class="f12">TOTAL</span>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                        </tbody>

                                    </table>
                                </tr>
                            </table>

                        </tr>
                    </table>
                </td>
                <td width="50%">
                    <table>
                        <tr>

                            <table>

                                <tr>
                                    <table style="margin-top:10px;">
                                        <thead>
                                            <tr>
                                                CATEGORIA B
                                            </tr>
                                            <tr>
                                                <th>
                                                    <span class="f12">UNID</span>

                                                </th>
                                                <th>
                                                    <span class="f12">DESCR</span>

                                                </th>
                                                <th>
                                                    <span class="f12">PRECIO</span>

                                                </th>
                                                <th>
                                                    <span class="f12">TOTAL</span>

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>ITEM</td>
                                                <td>12</td>
                                                <td>12</td>
                                        </tbody>

                                    </table>
                                </tr>
                            </table>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table> --}}
    {{-- <footer>
        <table width="100%" border="0" style="border-collapse: collapse;border-top:1px solid #ddd;margin-top:15px;">
            <tr>
                <td align="left" valign="middle" colspan="2">Direccion:{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }} -
                    Telefonos: {{ $establishment->telephone }} Email: {{ $establishment->email }}</td>
            </tr>
        </table>
    </footer> --}}
</body>


</html>
