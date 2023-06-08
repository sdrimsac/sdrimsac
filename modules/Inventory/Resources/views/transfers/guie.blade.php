<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de traslado</title>
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
</style>
<?php
function format($it)
{
    $quantity = $it->quantity;
    $item = $it->item;
    $unit_type_id = $item->unit_type_id;
    $max_qty = $it->item->max_quantity;
    $div = floatval($quantity / $max_qty);
    $part_int = intval($div);
    $parts = $div - $part_int;
    if ($parts != 0) {
        $part_dec = $parts * $max_qty;
    }

    $unit_type_dec = $unit_type_id;
    $units = $item->item_unit_types;
    foreach ($units as $unit) {
        if ($unit->quantity_unit == $max_qty) {
            $unit_type_dec = $unit->unit_type_id;
        }
    }
    $result = '';

    if ($part_int != 0) {
        $result .= $part_int . ' ' . $unit_type_id;
    }
    if (isset($part_dec)) {
        $result .= ' ' . $part_dec . ' ' . $unit_type_dec;
    }

    return $result;
}
?>

<body>
    <div id="register">

        <table border="0" style="border:0px solid;width:90%">
            <thead>
                <tr>
                    <th colspan="4" class="header_title">
                        @if ($company->trade_name)
                            {{ $company->trade_name }}
                        @else
                            {{ $company->name }}
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="header_title2">
                        GUIA DE TRASLADO GT-{{ format_serie($transfer->id) }}
                    </th>
                </tr>
                <tr>

                    <th colspan="3" class="header_title0">
                        ENVIADO: {{ $transfer->sender->name }}
                    </th>
                    <th class="header_title0">
                        FECHA: {{ $transfer->created_at->format('d/m/Y') }}
                    </th>
                </tr>
                <tr>
                    <th class="celda_left header_title0" colspan="4">
                        SALIDA:
                        <strong>
                            {{ $transfer->warehouse->description }}

                        </strong><br>
                        DESTINO:
                        <strong>
                            {{ $transfer->warehouse_destination->description }}
                        </strong>
                    </th>
                </tr>

            </thead>


        </table>

        <table border="0" style="border:0px solid;width:90%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="header_title1">#</th>
                    <th class="header_title1">PRODUCTO</th>
                    <th class="header_title1">CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfer->detail as $idx => $it)
                    <tr>
                        <td class="description_preparacion">{{ $idx + 1 }}</td>
                        <td class="description_preparacion">
                            <b>

                                {{ $it->item->description }}
                            </b><br>


                            @if (isset($it->series_lots))
                                @foreach ($it->series_lots['lotes'] as $lot)
                                    <br><small>Lote: {{ $lot['code'] }} - Cant. {{ $lot['quantity'] }}</small>
                                @endforeach
                            @endif
                        </td>
                        <td class="celda_center description_preparacion">
                            @if (isset($it->item->max_quantity))
                                {{-- {{ number_format($it->quantity / $it->item->max_quantity, 2) }} --}}
                                {{-- {{ $it->item->unit_type_id }} --}}
                                {{ format($it) }}
                                <div style="padding:0px">
                                    <small style="padding:0px" class="small">
                                        {{ $it->quantity }} unds
                                    </small>
                                    <small style="padding:0px" class="small">
                                        {{ $it->item->max_quantity }} factor
                                    </small>
                                </div>
                            @else
                                {{ $it->quantity }} {{ $it->item->unit_type_id }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table border="0" style="border:0px solid;width:90%; margin-top: 10px;">
            <tbody>
                <tr>
                    <td colspan="3" class="header_title0">
                        Código de traslado: <strong>
                            <span class="header_title2">

                                {{ $transfer->code }}
                            </span>
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
