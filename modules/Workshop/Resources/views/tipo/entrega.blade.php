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
    <div id="register">
        <table border="0" style="border:0px solid;width:75%">
            <tr>
                <td colspan="4" class="header_title text-center" valign="top">
                    <strong>TICKET DE ENTREGA</strong>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="encabezado text-center header_title2">
                    @if ($company->trade_name)
                        {{ $company->trade_name }}
                    @else
                        {{ $company->name }}
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title0 text-center under_line" valign="top">
                    <strong>FECHA:
                        {{ $updated_at ? \Carbon\Carbon::parse($updated_at)->format('d/m/Y H:i') : 'N/A' }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title1 text-center" valign="top">
                    MECANICO: {{ $mecanico }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title1 text-center" valign="top">
                    PLACA: {{ $placa }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="header_title1 text-center" valign="top">
                    ORDEN DE TRABAJO: {{ $historial_id }}
                </td>
            </tr>
            <tr>
                <td colspan="1" class="cell_number encabezado header_title2">
                    <strong>#</strong>
                </td>
                <td colspan="1" class="encabezado text-center header_title2">
                    <strong>CODIGO</strong>
                </td>
                <td colspan="1" class="encabezado text-center header_title2">
                    <strong>PRODUCTO</strong>
                </td>
                <td colspan="1" class="encabezado text-center header_title2">
                    <strong>CANTIDAD</strong>
                </td>
            </tr>
            <tbody>
                @foreach ($historialItems as $item)
                    <tr>
                        <td class="description_preparacion">{{ $loop->iteration }}</td>
                        <td class="description_preparacion">
                            {{ $item->item->internal_id ?? 'N/A' }}
                        </td>
                        <td class="celda_center description_preparacion">
                            {{ $item->item->description ?? 'Sin descripción' }}
                        </td>
                        <td class="celda_center description_preparacion">
                            {{ $item->cantidad }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" height="40"></td>
                </tr>
                <tr>
                    <td colspan="3" class="">_________________ <br> <strong>Firma Mecaníco</strong></td>
                    <td colspan="2" class="">_________________ <br> <strong>Firma Encargado</strong></td>
                </tr>
                <tr>
                    <td colspan="4" height="40"></td>
                </tr>
                <tr>
                    <td colspan="4" class="header_title1 text-center" valign="top">
                        <strong>Gracias por su trabajo. Verifique el repuesto antes de su uso</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
