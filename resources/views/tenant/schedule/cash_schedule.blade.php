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
            margin: 3px;
            padding: 5px;
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
            padding: 4.5px;
            border: 0.1px solid #000;
            font-size: 8px;
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
            font-size: 8px;
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
            margin: 15px;
        }

        td,
        th {
            font-size: 10px !important;
            height: 15px;
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


    </style>

<body>
    @if ($sale->status !== 'A' && $sale->status !== null)
        <div class="company_logo_box"
            style="position: absolute; text-align: center; top:30%;
    left: 0; right: 0; margin: auto; width: 100%; height: 100px;
    color: red; font-size: 50px; font-weight: bold; font-family: Arial, sans-serif;
    transform: rotate(-45deg); -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg); -o-transform: rotate(-45deg); -ms-transform: rotate(-45deg);
    opacity: 0.3; filter: alpha(opacity=10); z-index: -1;
">
            SIN VALOR LEGAL
        </div>
    @endif
    <table class="full-width">
        @foreach (range(0, 2) as $index)
            <td width="30%">
                
                    <table class="full-width">
                        <thead>
                            <tr>
                            <th colspan="6" class="celda_left">
                                    @if ($company->document_logo)
                                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                            alt="{{ $company->trade_name }}" style="max-width: 100px;">
                                    @else
                                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                            alt="{{ $company->trade_name }}" style="max-width: 100px;">
                                    @endif
                            </th>
                        </tr>
                            <tr>
                                <th colspan="6" class="celda_left">
                                    <strong>FECHA:</strong>
                                    {{ $sale->date_of_issue->format('Y-m-d') }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="celda_left">
                                    <strong>CLIENTE:</strong>
                                    {{ $sale->customer->name }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="celda_left">
                                    <strong>DNI:</strong>
                                    {{ $sale->customer->number }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="celda_left">
                                    <strong>DIRECCION:</strong>
                                    {{ $sale->customer->address }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" class="celda_left">
                                    <strong>CELULAR:</strong>
                                    {{ $sale->customer->telephone }}
                                </th>
                                <th colspan="3" class="celda_left">
                                    <strong>FIRMA:</strong>
                                    ..........................
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3" class="celda_left">
                                    <strong>MONTO:</strong>
                                    {{ number_format($sale->total, 2) }}
                                </th>
                                <th colspan="3" class="celda_left">
                                    <strong>CUOTA</strong>
                                    {{ number_format($data->first()['amount'], 2) }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" class="celda_left">
                                    <strong>{{ strtoupper($sale->type_payment) }}:</strong>
                                    {{ count($data) }}
                                </th>
                            </tr>
                            <tr>
                                <th class="celda">
                                    N°
                                </th>
                                <th class="celda">
                                    FECHA
                                </th>
                                <th class="celda">
                                    CUOTA
                                </th>
                                <th class="celda">
                                    AMORT.
                                </th>
                                <th class="celda">
                                    MORA
                                </th>
                                <th class="celda">
                                    TOTAL
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $pay)
                                <tr>
                                    <td class="celda">
                                        
                                        {{ $loop->iteration + (($page-1) * 17) }}
                                    </td>
                                    <td class="celda">
                                        {{ $pay['date_payment'] }}
                                    </td>
                                    <td class="celda"></td>
                                    <td class="celda"></td>
                                    <td class="celda"></td>
                                    <td class="celda"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </td>
            @if ($index < 2)
                <td width="5%">
                

                </td>

            @endif
        @endforeach
    </table>
</body>
