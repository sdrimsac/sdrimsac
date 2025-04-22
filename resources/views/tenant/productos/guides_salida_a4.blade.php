<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Ingreso Y Salida de Productos</title>
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
    }

    .celda_center {
        text-align: center;
        padding: 5px;
    }

    .celda_right {
        text-align: right;
        padding: 5px;
    }

    .border-bottom {
        border-bottom: 1px solid rgb(49, 49, 49);
    }

    th {
        padding: 5px;
        text-align: center;
        border-color: #409EFF;
    }

    .headers {
        padding: 5px !important;
        height: 25px;
    }

    .title {
        font-weight: bold;
        padding: 5px;
        font-size: 20px !important;
        text-decoration: underline;
    }

    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 2cm;
        color: #000;
        text-align: center;
        padding: 10px;
        font-size: 12px;
        font-family: Arial;
    }

    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1.5cm;
        color: #000;
        text-align: center;
        font-size: 11px;
        padding: 10px;
        font-family: Arial;
    }

    @page {
        margin: 2cm;
        size: A4;
    }

    td,
    th {
        font-size: 10px !important;
        height: 15px;
    }

    .small {
        font-size: 8px !important;
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
    }

    .header_title2 {
        font-size: 14px !important;
    }
</style>

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
                        GUIA DE MOVIMIENTO MT-{{ format_serie($transfer->id) }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2" class="header_title0">
                        MOVIMIENTO:
                        @if ($transfer->inventoryTransaction->type === 'input')
                            INGRESO
                        @elseif ($transfer->inventoryTransaction->type === 'output')
                            SALIDA
                        @else
                            {{ $transfer->inventoryTransaction->type }}
                        @endif
                    </th>
                    <th class="header_title0">
                        FECHA: {{ $transfer->created_at->format('d/m/Y') }}
                    </th>
                </tr>
                <tr>
                    <th class="celda_left header_title0" colspan="4">
                        <strong>
                            {{ $transfer->warehouse->description }}
                        </strong><br>
                    </th>
                </tr>
            </thead>
        </table>

        <table border="0" style="border:0px solid;width:90%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="header_title1">#</th>
                    <th class="header_title1">CODIGO</th>
                    <th class="header_title1">PRODUCTO</th>
                    <th class="header_title1">CANTIDAD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="description_preparacion">1</td>
                    <td class="description_preparacion">
                        {{ $transfer->item->internal_id }}
                    </td>
                    <td class="description_preparacion">
                        {{ $transfer->item->description }}
                    </td>
                    <td class="celda_center description_preparacion">
                        {{ $transfer->quantity }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
