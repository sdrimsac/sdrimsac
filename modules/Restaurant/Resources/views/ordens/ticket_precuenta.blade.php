<!DOCTYPE html>
<html lang="en">
@php
    // $configuration = App\Models\Tenant\Configuration::getPublicConfig();
@endphp

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

    .bold {
        font-weight: bold;
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
        margin: 3px;
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
</style>


<body>
    @php
        $precuenta = isset($precuenta) ? (bool) $precuenta : false;
        $configuration = App\Models\Tenant\Configuration::first();
    @endphp
    <div id="register">
        <table border="0" style="border:0px solid;width:75%">
            @if ($precuenta)
                <tr>
                    <td colspan="4" class="header_title text-center" valign="top">
                        <strong>PRECUENTA</strong><br>
                        <strong>ORDEN NRO. {{ $orden }}</strong>
                    </td>
                </tr>
                @if ($area_desc)
                    <tr>
                        <td colspan="4" class="header_title0 text-center under_line" valign="top">
                            <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4" class="header_title1 text-center" valign="top">
                        {{ $date }}
                    </td>
                </tr>

                @if ($is_restaurant)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            USUARIO: {{ join(', ', $users) }}
                        </td>
                    </tr>
                @endif

                <tr>
                    <td colspan="1" class="cell_number encabezado header_title2">
                        <strong>#</strong>
                    </td>
                    <td colspan="3" class="encabezado text-center header_title2">
                        <strong>PRODUCTO</strong>
                    </td>
                </tr>
                <tbody>
                    <?php $total = 0; ?>
                    @foreach ($orden_items as $row)
                        <?php $total += $row->price * $row->quantity; ?>
                        <tr>
                            <td class="celda_center header_title2">{{ $row->quantity }}</td>
                            <td colspan="3" class="celda_left header_title2 border-bottom">
                                <strong>{{ strtoupper($row->desc_unit) }}</strong>
                                @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                    / {{ strtoupper($row->food->item->second_name) }}
                                @endif
                                @if ($row->observations != '-')
                                    <br><strong>Obs: {{ $row->observations }}</strong>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class="encabezado text-right" colspan="3">Total S/</th>
                        <th class="encabezado">{{ number_format($total, 2) }}</th>
                    </tr>
                </tbody>
            @endif
        </table>

        @if ($precuenta && $configuration->text_comanda)
            <div class="text-center" style="width:75%">
                @if ($configuration->text_one)
                    <label class="header_title0 bold">{{ mb_strtoupper($configuration->text_one) }}</label><br>
                @endif
                @if ($configuration->text_two)
                    <label class="header_title0 bold">{{ mb_strtoupper($configuration->text_two) }}</label>
                @endif
            </div>
        @endif
    </div>
</body>
</html>
