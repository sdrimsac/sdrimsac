@php
    $configuration = \App\Models\Tenant\Configuration::select('show_logo_in_documents')->first();
    $stablishment = $establishment;

@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Recibo de Pago</title>
    <style>
        html {
            /* margin: 3px; */
            /* padding: 5px; */
            font-family: sans-serif;
            font-size: 8px;
        }

        table {
            width: 100%;
            border-spacing: 0;

        }

        .mini {
            font-size: 9px !important;
        }

        .mini2 {
            font-size: 10px !important;
        }

        .table {
            /* border: 0.1px solid #ccc; */
        }

        .celda {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #000;
        }

        .celda_sm {
            text-align: center;
            height: 25px;

            font-size: 7px !important;
            border: 0.1px solid #000;
        }

        .celda_left {
            text-align: left;

            /* border: 0.1px solid #ccc; */
        }

        .celda_center {
            text-align: center;
            padding: 5px;
            /* border: 0.1px solid #ccc; */
        }

        .celda_right {
            text-align: right;
            padding: 5px;
            /* border: 0.1px solid #ccc; */
        }

        tr:nth-child(even) {}

        .nth-child {
            background-color: transparent;
        }

        .border-bottom {
            border-bottom: 1px solid rgb(49, 49, 49);
        }

        th {
            padding: 5px;
            text-align: center;
            border-color: #409EFF;
            /* border: 0.1px solid #ccc; */
        }

        .headers {
            padding: 5px !important;
            /* border-bottom:0.1px solid #ccc; */
            height: 25px;
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
            background-color: #eee;
            text-transform: uppercase;
            padding: 2px;
            padding-left: 2px;
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
            /* border: 0.1px solid #ccc; */
        }

        .celda_descrip {
            width: 60% !important;
            text-align: left;
            padding: 5px;
            /* border: 0.1px solid #ccc; */
        }

        .celda_date {
            width: 30% !important;
            text-align: center;
            padding: 5px;
            /* border: 0.1px solid #ccc; */
        }

        .celda_left {
            text-align: left;
            padding: 2px;
            /* border: 0.1px solid #ccc; */
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

        .sinbordes {
            border: 0px !important;
            height: 15px !important;
        }

        h5 {
            padding: 0px !important;
            margin: 0px !important;
        }

        @page {
            margin: 0cm 0cm;
            /* margin: 15px; */
        }


        .company_logo_ticket {
            max-width: 150px;
            max-height: 70px;
        }

        .description {
            font-size: 13px;
        }

        .desc {
            font-size: 9px;
        }

        .description_preparacion {
            font-size: 11px !important;
        }

        .text-center {
            text-align: center;
        }

        .border-top-bottom {
            border-top: thin solid #333;
            border-bottom: thin solid #333;
        }

        .header_title {
            font-size: 20px !important;
        }

        .header_title0 {

            font-size: 12px !important;
        }

        .header_title1 {

            font-size: 10px !important;
        }

        .under_line {
            text-decoration: underline;
        }

        .cell_number {
            width: 10% !important;
            /* border: 0.1px solid #ccc; */
        }

        .header_title2 {

            font-size: 14px !important;
        }

        h4,
        h3,
        h5,
        h1,
        h6 {
            margin: 0px !important;
            padding: 0px !important;
        }

        p {
            margin: 0px !important;
            padding: 3px !important;
        }

        .border-rounded {
            border-radius: 10px;
            border: 1px solid #000;
            padding: 5px;
            min-height: 150px;
        }

        .btr {
            border-top-right-radius: 10px;
        }

        .btl {
            border-top-left-radius: 10px;
        }

        .bbr {
            border-bottom-right-radius: 10px;
        }

        .bbl {
            border-bottom-left-radius: 10px;
        }
    </style>

<body>


    <table border="0" style="width: 80%">
        <div class="text-center">
            <p>
                <strong class="header_title0 under_line">
                    TICKET DE DESEMBOLSO CRÉDITO EFECTIVO
                </strong>
            </p>
        </div>
        <p class="description">
            <strong>FECHA DE EMISION: </strong>{{ $sale->date_of_issue->format('Y-m-d') }}
        </p>
        <p class="description">
            <strong>FECHA DE DESEMBOLSO DE EFECTIVO: </strong> {{ $sale->date_of_issue->format('Y-m-d') }}
        </p>
        <p class="description">
            <strong>USUARIO: </strong>{{ $user->name }}
        </p>
        <p class="description">
            <strong>TIPO DE CRÉDITO: </strong>EFECTIVO
        </p>
        <p class="description">
            <strong>TIPO DE CUOTA: </strong> {{ mb_strtoupper($sale->type_payment) }}
        </p>
        <p class="description">
            <strong>NOMBRE DEL CLIENTE:</strong> {{ $sale->customer->name }}
        </p>
        <p class="description">
            <strong>DNI DEL CLIENTE:</strong> {{ $sale->customer->number }}
        </p>
        <p class="description">
            <strong>MONTO DEL CRÉDITO:</strong> {{ floatval($quote) * count($data) }}
        </p>
        <p>
            <strong>MONTO A DESEMBOLSAR:</strong> <span class="description">
                {{ $sale->total }}
            </span>
        </p>
        <br><br>
        <table>
            <tr>
                <td width="48%">
                    <div class="text-center">
                        ______________________________
                    </div>
                    <div class="text-center description">
                        USUARIO
                    </div>

                </td>
                <td width="4%"></td>
                <td width="48%">
                    <div class="text-center">
                        ______________________________
                    </div>
                    <div class="text-center description">
                        CLIENTE
                    </div>
                </td>
            </tr>
        </table>
    </table>
</body>
