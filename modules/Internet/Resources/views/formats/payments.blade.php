<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
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

    .to-top {
        vertical-align: top;
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

    .description_preparacion {
        font-size: 11px !important;
    }

    .text-center {
        text-align: center;
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

    th {
        border: 0.1px solid black;
    }

    .bordered td {
        border: 0.1px solid black;

    }
</style>

<body>
    <div class="text-center ">
        <h2 class="title">{{ $company->name }}</h2>
        <h3>ESTADO DE CUENTA</h3>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <td class="to-top header_title0">
                    <strong>CLIENTE:</strong> {{ $person->name }}
                </td>
                <td class="to-top header_title0">
                    <strong>FECHA:</strong> {{ date('d/m/y') }}
                </td>
            </tr>
            @if (isset($last_payment))
                @if ($last_payment->rest > 0)
                    <tr>
                        <td colspan="2" class="to-top header_title0">
                            @php
                                //get from last payment start_date and end_date, concat in a string whit format d/mY
                                $start_date = $last_payment->start_date;
                                $end_date = $last_payment->end_date;
                                if (is_string($start_date)) {
                                    $start_date = \Carbon\Carbon::parse($start_date);
                                }
                                if (is_string($end_date)) {
                                    $end_date = \Carbon\Carbon::parse($end_date);
                                }
                                $period = $start_date->format('d/m/y') . ' - ' . $end_date->format('d/m/y');
                            @endphp
                            <strong>DEUDA:</strong> {{ $last_payment->rest }} {{ $period }}
                        </td>

                    </tr>
                @endif
            @endif
        </tbody>
    </table>
    @if (count($payments) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>FECHA</th>
                    <th>DOCUMENTO</th>
                    <th>PAGO</th>
                </tr>
            </thead>
            <tbody class="bordered">
                @foreach ($payments as $idx => $record)
                    @php
                        $document = $record->get_document();
                        $date_of_issue = $document->date_of_issue;
                        if (is_string($date_of_issue)) {
                            $date_of_issue = \Carbon\Carbon::parse($date_of_issue);
                        }
                        $date_of_issue = $date_of_issue->format('d/m/Y');
                    @endphp
                    <tr>
                        <td class=" header_title0 celda_center">{{ $idx + 1 }}</td>
                        <td class=" header_title0 celda_center">{{ $date_of_issue }}</td>
                        <td class=" header_title0 celda_center">{{ $document->getNumberFullAttribute() }}</td>
                        <td class=" header_title0 celda_right">{{ $document->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="header_title0 text-center">
            <h3>No hay registros</h3>
        </div>
    @endif

</body>

</html>
