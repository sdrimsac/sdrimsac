<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promoción</title>
</head>
<?php
function format_serie($id)
{
    if (10 > $id) {
        return '000' . $id;
    }
    if (100 > $id) {
        return '00' . $id;
    }
    if (100 > $id) {
        return '0' . $id;
    }

    return '000' . $id;
}
?>
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
        /* border: 0.1px solid #ccc; */
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

    th {
        padding: 1.5px;
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
        /* height: 15px; */
    }

    .small {
        font-size: 8px !important;
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

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }
</style>
<?php

?>

<body>
    <div id="register">

        <table border="0" style="border:0px solid;width:90%">
            <thead>
                <tr>
                    <th colspan="4" class="header_title text-center">
                        @if ($company->trade_name)
                            {{ $company->trade_name }}
                        @else
                            {{ $company->name }}
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="header_title0 text-center">
                        HABITACIÓN: {{ $record->room }}
                    </th>
                </tr>
                <tr>


                    <th colspan="4" class="header_title0 text-center">

                        FECHA: {{ $record->created_at }}
                    </th>

                </tr>



            </thead>

            <tbody>
                <tr>
                    <td colspan="4" class="header_title0 text-left">
                        <strong>HUESPED:</strong> {{ $record->customer_name }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="header_title0 text-left">
                        <strong>DOCUMENTO:</strong> {{ $record->customer_number }}
                    </td>
                </tr>
                <tr style="height: 14px;">
                    <td colspan="4" class="header_title0 text-left">
                        <strong>
                            PROMOCIÓN:

                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="header_title0">
                        {{ $record->room_service->name }} CANT. {{ $record->quantity }}
                    </td>

                </tr>
            </tbody>

        </table>
        <div style="text-align: center;margin-top:10px;">
            @php
                $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                
                echo '<img style="max-height: 25px" src="data:image/png;base64,' . base64_encode($generator->getBarcode($record->code, $generator::TYPE_CODE_128, 3, 57)) . '">';
            @endphp
        </div>
        <div class="text-center">
            <h3>
                {{ $record->code }}
            </h3>
        </div>

        <div style="margin-top:15px;">

            <table border="0" style="border:0px solid;width:100%">
                <tbody>
               
                    <tr>
                        <td colspan="4" class="header_title0 text-left">
                            <strong>CAJERO:</strong> {{ $record->user_name }}
                        </td>
                    </tr>
            

                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
