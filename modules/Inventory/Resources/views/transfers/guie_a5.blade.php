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
@if (!function_exists('format_serie'))
    <?php
    function format_serie($id)
    {
        if ($id < 10) {
            return '000' . $id;
        }
        if ($id < 100) {
            return '00' . $id;
        }
        if ($id < 1000) {
            return '0' . $id;
        }
        return $id;
    }
    ?>
@endif
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

        font-size: 12px !important;
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

    .large-text {
        font-size: 16px !important;
        /* Adjust the size as needed */
    }

    /* Updating styles for "Para llevar" section with darker background */
    .para-llevar-header {
        background-color: #777777 !important;
        /* Darker gray background */
        color: #000000 !important;
        /* Keep text black for readability */
        font-weight: bold;
        -webkit-print-color-adjust: exact !important;
        /* For Chrome */
        color-adjust: exact !important;
        /* Standard */
        print-color-adjust: exact !important;
        /* Firefox */
    }

    /* Estilos para la marca de agua */
    /* .watermark-container {
        position: relative;
        min-height: 100%;
        overflow: visible;
    } */

    /* .watermark {
        position: fixed;
        top: 0%;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
        display: flex;
        justify-content: center;
        align-items: center;
    } */

    .watermark img {
        /* opacity: 0.3; */
        transform: rotate(7deg);
        max-width: 70%;
        max-height: 70%;
        /* margin-top: 50px; */
    }

    .menaje img {
        transform: rotate(0deg);
        max-width: 70%;
        max-height: 70%;
    }

    .comanda img {
        max-width: 100%;
        max-height: 100%;
    }

    #register {
        position: relative;
        z-index: 1;
        width: 100%;
    }
</style>


<body>

    <?php
    /* function format($it)
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
                $unit_type_dec = $unit->description;
            }
        }
    
        $result = '';
    
        if ($part_int != 0) {
            $result .= $part_int . ' ' . $unit_type_dec;
        }
        if (isset($part_dec)) {
            $result .= ' ' . $part_dec . ' ' . $unit_type_dec;
        }
    
        return $result;
    } */
    ?>
    <div id="register">
        <table border="0" style="border:0px solid;width:75%">

            <tr>
                <td colspan="4" class="header_title text-center " valign="top">
                    @if ($company->trade_name)
                        {{ $company->trade_name }}
                    @else
                        {{ $company->name }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                    GUIA DE TRASLADO GT-{{ format_serie($transfer->id) }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                    ENVIADO: {{ $transfer->sender->name }}
                </td>
                <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                    FECHA: {{ $transfer->created_at->format('d/m/Y') }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                    SALIDA:
                    <strong>
                        {{ $transfer->warehouse->description }}

                    </strong><br>
                    DESTINO:
                    <strong>
                        {{ $transfer->warehouse_destination->description }}
                    </strong>
                </td>
            </tr>

            <tr>
                <td colspan="1" class=" cell_number encabezado header_title2">
                    <strong>#</strong>
                </td>

                <td class="encabezado header_title2 text-center">
                    <strong>PRODUCTO</strong>
                </td>
                <td class="encabezado header_title2 text-center">
                    <strong>IMP.</strong>
                </td>
                <td class="encabezado header_title2 text-center">
                    <strong>CANTIDAD.</strong>
                </td>

            </tr>

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
                                {{ $it->max_quantity }}
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
    </div>
</body>

</html>
