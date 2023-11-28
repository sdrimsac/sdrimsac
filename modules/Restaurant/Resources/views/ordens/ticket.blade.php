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
    .bold{
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

    @endphp
    <div id="register">

        <table border="0" style="border:0px solid;width:75%">

            @if ($to_kitchen)
                @if ($is_restaurant)
                    <tr>
                        <td colspan="4" class="header_title text-center " valign="top">
                            <strong>NRO. MESA {{ strtoupper(str_pad($ordenes->mesa->number, 2, '0', STR_PAD_LEFT)) }}
                            </strong>
                        </td>
                    </tr>
                    @if ($configuration->reference_ticket && $ordenes->ref)
                        <tr>
                            <td colspan="4" class="header_title text-center " valign="top">
                                <strong>{{ $ordenes->ref }}</strong>
                            </td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <td colspan="4" class="header_title0 text-center" valign="top">
                        @if ($precuenta)
                        <strong>PRECUENTA</strong><br>
                        @endif
                        <strong>ORDEN NRO. {{ $orden }}</strong>
                    </td>
                </tr>
                @if ($area_desc)
                    <tr>
                        <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                            <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4" colspan="4" class=" text-center header_title1" valign="top">

                        {{ $date }}</td>
                </tr>
            @endif
            @if (!$to_kitchen)
                <tr>
                    <td colspan="4" class="header_title text-center " valign="top">
                        <strong>NRO. MESA {{ strtoupper(str_pad($ordenes->mesa->number, 2, '0', STR_PAD_LEFT)) }}
                        </strong>
                    </td>
                </tr>
                @if ($configuration->reference_ticket && $ordenes->ref)
                    <tr>
                        <td colspan="4" class="header_title text-center " valign="top">
                            <strong>{{ $ordenes->ref }}</strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="4" class="header_title0 text-center" valign="top">
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
                    <td colspan="4" colspan="4" class="header_title1 text-center" valign="top">

                        {{ $date }}</td>
                </tr>
                
            @endif
            @if ($is_restaurant)
                <tr>
                    <td colspan="4" class="header_title1 text-center" valign="top">
                        USUARIO: {{ join(', ', $users) }} </strong>
                    </td>
                </tr>
            @endif
            {{-- @if ($ordenes->to_carry == 1)
            <tr>
                <td  colspan="4" class="celda_left sinbordes" valign="top" style="font-size: 12px !important; text-align: center;">
                   <strong>PEDIDO PARA LLEVAR </td>
           </tr>
            @endif --}}
            <tr>
                <td colspan="1" class=" cell_number encabezado header_title2">
                    <strong>#</strong>
                </td>
                @if ($to_kitchen)
                    <td class="encabezado header_title2 text-center">
                        <strong>PRODUCTO</strong>
                    </td>
                    <td class="encabezado header_title2 text-center">
                        <strong>IMP.</strong>
                    </td>
                    <td class="encabezado header_title2 text-center">
                        <strong>SUB.</strong>
                    </td>
                @else
                    <td colspan="3" class="encabezado  text-center header_title2">
                        <strong>PRODUCTO</strong>
                    </td>
                @endif
            </tr>

            @if ($to_kitchen)
                <tbody>
                    <?php
                    $total = 0;
                    ?>
                    @foreach ($orden_items as $row)
                        <?php
                        $total = $total + $row->price * $row->quantity;
                        ?>
                        <tr>
                            <td class="text-center header_title2">
                                @if ($show_unit_ticket && isset($row->qty_unit))
                                    {{ $row->quantity, 2 }}
                            </td>
                        @else
                            {{ $row->quantity }}</td>
                    @endif
                    <td class="celda_left header_title2 border-bottom">
                        <strong>
                            {{ strtoupper($row->desc_unit) }}
                            @if ($row->food->item->second_name)
                                / {{ strtoupper($row->food->item->second_name) }}
                            @endif
                        </strong>
                        @if ($row->observations != '-')
                            <br>
                            <strong>Obs: {{ $row->observations }}</strong>
                        @endif

                    </td>
                    <td class="celda_center description_preparacion">
                        @if ($show_unit_ticket && isset($row->price_unit))
                            {{ number_format($row->price, 2) }}
                        @else
                            {{ number_format($row->price, 2) }}
                        @endif
                    </td>
                    @php
                        $total_price = $row->price * $row->quantity;
                    @endphp
                    <td class="celda_center description_preparacion">{{ number_format($total_price, 2) }}</td>
                    </tr>
            @endforeach
            <tr>
                <th class="encabezado description_preparacion" colspan="3" style="text-align: right">Total S/ </th>
                <th class="encabezado description_preparacion">{{ number_format($total, 2) }}</th>
            </tr>
            </tbody>
        @else
            <tbody>
                <?php
                $total = 0;
                ?>
                @foreach ($orden_items as $row)
                    <?php
                    $total = $total + $row->price * $row->quantity;
                    ?>
                    @if (!$row->to_carry)
                        <tr>
                            <td class="celda_center header_title2">{{ $row->quantity }}</td>
                            <td colspan="3" class="celda_left header_title2 border-bottom">
                                <strong>
                                    {{ strtoupper($row->desc_unit) }}
                                    @if ($row->food->item->second_name)
                                        / {{ strtoupper($row->food->item->second_name) }}
                                    @endif
                                </strong>
                                @if ($row->observations != '-')
                                    <br>
                                    <strong>Obs: {{ $row->observations }}</strong>
                                @endif

                            </td>

                        </tr>
                    @endif
                @endforeach
                @if (count($to_carry) != 0)
                    <tr>
                        <th class="encabezado text-center header_title2" colspan="4">Para llevar </th>
                    </tr>
                    @foreach ($to_carry as $row_carry)
                        <tr>
                            <td class="celda_center header_title2">{{ $row_carry->quantity }}</td>
                            <td colspan="3" class="celda_left header_title2 border-bottom">
                                <strong>
                                    {{ strtoupper($row_carry->desc_unit) }}
                                    @if ($row->food->item->second_name)
                                        / {{ strtoupper($row->food->item->second_name) }}
                                    @endif
                                </strong>
                                @if ($row_carry->observations != '-')
                                    <br>
                                    <strong>Obs: {{ $row_carry->observations }}</strong>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                @endif
                @if ($to_kitchen)
                    <tr>
                        <th class="encabezado" colspan="3" style="text-align: right">Total S/ </th>
                        <th class="encabezado">{{ number_format($total, 2) }}</th>
                    </tr>
                @endif
            </tbody>
            @endif

        </table>
        <br>
        @if ($to_kitchen && $configuration->text_comanda)
           <div class="text-center"  style="width:75%">
            @if ($configuration->text_one)
            <label class="header_title0 bold">
                {{ mb_strtoupper($configuration->text_one) }}
            </label>
            <br>
        @endif
        @if ($configuration->text_two)
            <label class="header_title0 bold">
                {{ mb_strtoupper($configuration->text_two) }}
            </label>
        @endif
           </div>
        @endif
    </div>

</body>

</html>
