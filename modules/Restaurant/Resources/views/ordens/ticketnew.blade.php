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
        border: 0.1px solid #030000;
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
        background-color: #eeeeee;
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
        background-color: #f70b0b !important;
        /* Fondo negro puro */
        color: #fdfdfd !important;
        /* Texto blanco para contraste */
        font-weight: bold;
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
        print-color-adjust: exact !important;
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
    @php
        $precuenta = isset($precuenta) ? (bool) $precuenta : false;
        $re_printer = isset($re_printer) ? (bool) $re_printer : false;
        $configuration = App\Models\Tenant\Configuration::first();
        //$establishment = App\Models\Tenant\Establishment::first();
    @endphp

    @if ($configuration->imprimir_comanda_cocina)
        {{-- Content for imprimir_comanda_cocina --}}
        @if (isset($es_anulacion) && $es_anulacion === true)
            <div class="watermark">
                <img src="{{ asset('status_images/anulado.png') }}" alt="Anulado" />
            </div>
        @endif
        @if (isset($es_anulacion_item) && $es_anulacion_item === true)
            <div class="watermark">
                <img src="{{ asset('status_images/anulado.png') }}" alt="Anulado" />
            </div>
        @endif
        @if (isset($area_desc) && strtoupper($area_desc) === 'MENAJE')
            <div class="menaje">
                <img src="{{ asset('status_images/menaje.png') }}" alt="menaje" />
            </div>
        @endif
        @if (
            !$to_kitchen &&
                $configuration->nane_comand &&
                !(isset($area_desc) && strtoupper($area_desc) === 'MENAJE') &&
                !(isset($es_anulacion) && $es_anulacion === true))
            <div class="menaje">
                <img src="{{ asset('status_images/comanda.png') }}" alt="comanda" />
            </div>
        @endif
        @if ($to_kitchen && $configuration->nane_comand)
            <div class="menaje">
                <img src="{{ asset('status_images/precuenta.png') }}" alt="precuenta" />
            </div>
        @endif
        <div id="register">
            <table border="0" style="border:0px solid;width:75%">

                @if ($to_kitchen)

                    @if ($is_restaurant)
                        {{-- @if ($configuration->nane_comand)
                            <tr>
                                <td colspan="4" class="header_title text-center encabezado" valign="top">
                                    <strong>PRECUENTA</strong>
                                </td>
                            </tr>
                        @endif --}}
                        <tr>
                            <td colspan="4" class="header_title text-center " valign="top">
                                <strong>NRO.
                                    {{ strtoupper(str_pad($ordenes->mesa->number, 2, '0', STR_PAD_LEFT)) }}
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
                            <strong>ORDEN NRO. {{ $ordenes->correlative }}</strong>
                        </td>
                    </tr>
                    @if ($re_printer)
                        <tr>
                            <td colspan="4" class="header_title0 text-center under_line" valign="top">
                                <strong>REIMPRESIÓN</strong>
                            </td>
                        </tr>
                    @elseif ($area_desc)
                        <tr>
                            <td colspan="4" class="header_title0 text-center under_line" valign="top">
                                <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                            </td>
                        </tr>
                    @endif
                    {{-- @if ($area_desc)
                        <tr>
                            <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                                <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                            </td>
                        </tr>
                    @endif
                    @if ($re_printer)
                        <tr>
                            <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                                <strong>REIMPRESIÓN</strong>
                            </td>
                        </tr>
                    @endif --}}
                    <tr>
                        <td colspan="4" colspan="4" class=" text-center header_title1" valign="top">

                            {{ $date }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" colspan="4" class="text-center header_title1" valign="top">
                            @if (isset($zone_name) && $zone_name)
                                <strong>ZONA: {{ $zone_name }}</strong>
                            @endif
                        </td>
                    </tr>
                @endif
                @if (!$to_kitchen)
                    @if (!$configuration->nane_comand)
                        <tr>
                            <td colspan="4" class="header_title text-center encabezado" valign="top">
                                <strong>COMANDA</strong>
                            </td>
                        </tr>
                    @endif
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
                            <strong>ORDEN NRO. {{ $ordenes->correlative }}</strong>
                        </td>
                    </tr>
                    {{-- @if ($area_desc && strtoupper($area_desc) !== 'MENAJE')
                        <tr>
                            <td colspan="4" class="header_title0 text-center under_line" valign="top"
                                style="font-size: 20px !important;">
                                <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                            </td>
                        </tr>
                    @endif --}}
                    @if ($re_printer)
                        <tr>
                            <td colspan="4" class="header_title0 text-center under_line" valign="top">
                                <strong>REIMPRESIÓN</strong>
                            </td>
                        </tr>
                    @elseif ($area_desc)
                        <tr>
                            <td colspan="4" class="header_title0 text-center under_line" valign="top">
                                <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4" colspan="4" class="header_title1 text-center" valign="top">

                            {{ $date }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" colspan="4" class=" text-center header_title1" valign="top">
                            @if (isset($zone_name) && $zone_name)
                                <strong>ZONA: {{ $zone_name }}</strong>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($is_restaurant && $configuration->seller_mozo)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            @if (isset($mozo_name) && $mozo_name)
                                {{ $mozo_name }}
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($is_restaurant)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            USUARIO: {{ join(', ', $users) }} </strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="1" class="cell_number encabezado header_title2">
                        <strong>#</strong>
                    </td>
                    @if (count($to_carry) != 0)
                        <td colspan="3" class="encabezado  text-center header_title2">
                            <strong>PARA LLEVAR</strong>
                        </td>
                    @endif
                    @if ($to_kitchen)
                        <td class="encabezado header_title2 text-center">
                            <strong>PRODUCTO</strong>
                        </td>
                        <td class="encabezado header_title2 text-center text-white">
                            <strong>IMP.</strong>
                        </td>
                        <td class="encabezado header_title2 text-center text-white">
                            <strong>SUB.</strong>
                        </td>
                    @else
                        {{-- <td colspan="3" class="encabezado  text-center header_title2">
                            <strong>PRODUCTO</strong>
                        </td> --}}

                        {{-- <td colspan="3" class="encabezado  text-center header_title2">
                            <strong>PRODUCTO</strong>
                        </td> --}}
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
                                {{-- <td class="encabezado text-center header_title2"
                                    style="font-size: 24px !important; font-weight: bold;">
                                    @if ($show_unit_ticket && isset($row->qty_unit))
                                        {{ $row->quantity, 2 }}
                                    @else
                                        {{ $row->quantity }}
                                    @endif
                                </td> --}}
                                <td class="text-center" style="font-size: 24px !important; font-weight: bold;">
                                    @if ($show_unit_ticket && isset($row->qty_unit))
                                        {{ number_format($row->quantity, 2) }}
                                    @else
                                        {{ $row->quantity }}
                                    @endif
                                </td>

                                <td class="celda_left header_title2 border-bottom">
                                    <strong>
                                        {{ strtoupper($row->desc_unit) }}
                                        @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                            / {{ strtoupper($row->food->item->second_name) }}
                                        @endif
                                    </strong>
                                    @if ($row->observations != '-')
                                        <br>
                                        <strong>
                                            {{-- @if ($configuration->observations_separate)
                                        @php
                                            $observations = explode('/', $row->observations); 
                                        @endphp
                                        @foreach ($observations as $index => $observation)
                                            {{ strtoupper($row->desc_unit) }} OBSERVACIÓN {{ $index + 1 }}:
                                            {{ e(trim($observation)) }}
                                            
                                        @endforeach
                                    @else --}}
                                            Obs: {{ e($row->observations) }}
                                            {{-- @endif --}}
                                        </strong>
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
                                <td class="celda_center description_preparacion">{{ number_format($total_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="encabezado description_preparacion" colspan="3"
                                style="text-align: right; font-size: 20px !important;">
                                Total S/
                            </th>
                            <th class="encabezado description_preparacion" style="font-size: 20px !important;">
                                {{ number_format($total, 2) }}
                            </th>
                        </tr>
                        {{-- @if ($establishment->image_yape)
                            <tr>
                                <td colspan="4" class="text-center">
                                    <img src="{{ public_path('storage/uploads/logos/' . $establishment->image_yape) }}"
                                        alt="payment-logo" style="max-width: 200px; height: auto;" />
                                </td>
                            </tr>
                        @endif --}}
                        @if ($establishment && $establishment->image_yape)
                            <tr>
                                <td colspan="4" class="text-center">
                                    <img src="{{ public_path('storage/uploads/logos/' . $establishment->image_yape) }}"
                                        alt="payment-logo" style="max-width: 150px; height: auto;" />
                                </td>
                            </tr>
                        @endif
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
                                @php
                                    $observations = explode('/', $row->observations);
                                    $totalObservations = count($observations);
                                    $quantityPerObservation = $row->quantity / $totalObservations;
                                @endphp

                                @if ($configuration->observations_separate)
                                    @foreach ($observations as $index => $observation)
                                        <tr>
                                            <td class="celda_center header_title2">{{ 1 }}</td>
                                            <!-- Siempre muestra 1 por cada observación -->
                                            <td colspan="3" class="celda_left header_title2 border-bottom">
                                                <strong>
                                                    {{ strtoupper($row->desc_unit) }}
                                                    @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                                        / {{ strtoupper($row->food->item->second_name) }}
                                                    @endif
                                                </strong>
                                                <br>
                                                <strong>
                                                    Obs: {{ e(trim($observation)) }}
                                                </strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="celda_center header_title2"
                                            style="font-size: 20px !important; font-weight: bold;">
                                            {{ $row->quantity }}
                                        </td>
                                        <td colspan="3" class="celda_left header_title2 border-bottom">
                                            <strong>
                                                {{ strtoupper($row->desc_unit) }}
                                                @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                                    / {{ strtoupper($row->food->item->second_name) }}
                                                @endif
                                            </strong>
                                            @if ($row->observations != '-')
                                                <br>
                                                <strong>
                                                    @if ($configuration->observations_separate)
                                                        @php
                                                            $observations = explode('/', $row->observations); // Divide las observaciones por el carácter "/"
                                                        @endphp
                                                        @foreach ($observations as $index => $observation)
                                                            Obs{{ $index + 1 }}: {{ e($observation) }}<br>
                                                        @endforeach
                                                    @else
                                                        Obs: {{ e($row->observations) }}
                                                    @endif
                                                </strong>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                        @if (count($to_carry) != 0)
                            {{-- <tr class="para-llevar-header">
                                <th class="encabezado text-center header_title2" colspan="4">Para llevar </th>
                            </tr> --}}
                            @foreach ($to_carry as $row_carry)
                                <tr>
                                    <td class="celda_center header_title2">{{ $row_carry->quantity }}</td>
                                    <td colspan="3" class="celda_left header_title2 border-bottom">
                                        <strong>
                                            {{ strtoupper($row_carry->desc_unit) }}
                                            @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
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
                            @if ($establishment && $establishment->image_yape)
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <img src="{{ public_path('storage/uploads/logos/' . $establishment->image_yape) }}"
                                            alt="payment-logo" style="max-width: 150px; height: auto;" />
                                    </td>
                                </tr>
                            @endif
                        @endif

                    </tbody>
                @endif

            </table>
            <br>
            @if ($to_kitchen && $configuration->text_comanda)
                <div class="text-center" style="width:75%">
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
    @elseif ($configuration->imprimir_precuenta_comanda)
        {{-- Content for imprimir_precuenta_comanda --}}
        <div id="register">
            <table border="0" style="border:0px solid;width:75%">
                <!-- Información General -->
                <tr>
                    <td colspan="4" class="header_title text-center" valign="top">
                        <strong>NRO. MESA
                            {{ strtoupper(str_pad($ordenes->mesa->number, 2, '0', STR_PAD_LEFT)) }}</strong>
                    </td>
                </tr>

                @if ($configuration->reference_ticket && $ordenes->ref && !$precuenta)
                    <tr>

                        <td colspan="4" class="header_title text-center" valign="top">
                            <strong>{{ $ordenes->ref }}</strong>
                        </td>

                    </tr>
                @endif

                <tr>
                    <td colspan="4" class="header_title0 text-center" valign="top">
                        @if ($precuenta)
                            <strong>PRECUENTA</strong><br>
                        @endif
                        <strong>ORDEN NRO. {{ $orden }}</strong>
                    </td>
                </tr>
                @if ($re_printer)
                    <tr>
                        <td colspan="4" class="header_title0 text-center under_line" valign="top">
                            <strong>REIMPRESIÓN</strong>
                        </td>
                    </tr>
                @elseif ($area_desc)
                    <tr>
                        <td colspan="4" class="header_title0 text-center under_line" valign="top">
                            <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                        </td>
                    </tr>
                @endif

                {{-- @if ($area_desc)
                    <tr>
                        <td colspan="4" class="header_title0 text-center  under_line" valign="top">
                            <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                        </td>
                    </tr>
                @endif --}}
                <tr>
                    <td colspan="4" colspan="4" class=" text-center header_title1" valign="top">

                        {{ $date }}
                    </td>
                </tr>

                @if ($is_restaurant && $configuration->seller_mozo)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            @if (isset($mozo_name) && $mozo_name)
                                {{ $mozo_name }}
                            @endif
                        </td>
                    </tr>
                @endif

                @if ($is_restaurant)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            USUARIO: {{ join(', ', $users) }}
                        </td>
                    </tr>
                @endif

                <!-- Encabezados de Producto -->
                @if (!$precuenta)
                    @if (count($to_carry) != 0)
                        {{-- <tr>
                        <th class="encabezado text-center header_title2" colspan="4">Para llevar </th>
                    </tr> --}}
                        <tr class="para-llevar-header">
                            <th class="encabezado text-center header_title2" colspan="4"
                                style="color: rgb(12, 12, 12);">Para
                                llevar </th>
                        </tr>
                    @endif
                @endif
                <tr>
                    <td colspan="1" class="cell_number encabezado header_title2">
                        <strong>#</strong>
                    </td>
                    <td class="encabezado header_title2 text-center">
                        <strong>PRODUCTO</strong>
                    </td>
                    <td class="encabezado header_title2 text-center">
                        <strong>IMP.</strong>
                    </td>
                    <td class="encabezado header_title2 text-center">
                        <strong>SUB.</strong>
                    </td>
                </tr>

                <!-- Detalles de la Orden -->
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($orden_items as $row)
                        @php
                            $total += $row->price * $row->quantity;
                            $total_price = $row->price * $row->quantity;
                        @endphp
                        <tr>
                            <td class="text-center header_title2"
                                style="font-size: 22px !important; font-weight: bold;">
                                @if ($show_unit_ticket && isset($row->qty_unit))
                                    {{ $row->quantity, 2 }}
                                @else
                                    {{ $row->quantity }}
                                @endif
                            </td>
                            <td class="celda_left header_title2 border-bottom">
                                <strong>
                                    {{ strtoupper($row->desc_unit) }}
                                    @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                        / {{ strtoupper($row->food->item->second_name) }}
                                    @endif
                                </strong>
                                @if ($row->observations != '-')
                                    <br>
                                    <strong>
                                        @if ($configuration->observations_separate)
                                            @php
                                                $observations = explode('/', $row->observations); // Divide las observaciones por el carácter "/"
                                            @endphp
                                            @foreach ($observations as $index => $observation)
                                                {{ strtoupper($row->desc_unit) }} OBSERVACIÓN {{ $index + 1 }}:
                                                {{ e(trim($observation)) }}
                                                {{-- Obs{{ $index + 1 }}: {{ e($observation) }} --}}<br>
                                            @endforeach
                                        @else
                                            Obs: {{ e($row->observations) }}
                                        @endif
                                    </strong>
                                @endif
                            </td>
                            <td class="celda_center description_preparacion">
                                {{ number_format($row->price, 2) }}
                            </td>
                            <td class="celda_center description_preparacion">
                                {{ number_format($total_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th class="encabezado description_preparacion" colspan="3" style="text-align: right">Total
                            S/</th>
                        <th class="encabezado description_preparacion">{{ number_format($total, 2) }}</th>
                    </tr>
                    @if ($establishment && $establishment->image_yape)
                        <tr>
                            <td colspan="4" class="text-center">
                                <img src="{{ public_path('storage/uploads/logos/' . $establishment->image_yape) }}"
                                    alt="payment-logo" style="max-width: 150px; height: auto;" />
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <br>

            <!-- Texto adicional si es para la cocina -->
            @if ($to_kitchen && $configuration->text_comanda)
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
    @elseif ($configuration->comand_big)
        {{-- Content for comand_big --}}
        <div id="register" class="large-text">
            <table border="0" style="border:0px solid;width:75%">
                <!-- Header rows stay the same -->
                <tr>
                    <td colspan="4" class="header_title text-center" style="font-size: 24px !important;"
                        valign="top">
                        <strong>MESA {{ strtoupper(str_pad($ordenes->mesa->number, 2, '0', STR_PAD_LEFT)) }}</strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="header_title0 text-center" valign="top">
                        @if ($precuenta)
                            <strong>PRECUENTA</strong><br>
                        @endif
                        <strong>ORDEN NRO. {{ $orden }}</strong>
                    </td>
                </tr>
                {{-- @if ($area_desc)
                <tr>
                    <td colspan="4" class="header_title0 text-center  under_line"
                        style="font-size: 18px !important;" valign="top">
                        <strong>AREA: {{ strtoupper($area_desc) }} </strong>
                    </td>
                </tr>
            @endif --}}

                <tr>
                    <td colspan="4" colspan="4" class=" text-center header_title1" valign="top">
                        {{ $date }}
                    </td>
                </tr>
                @if ($is_restaurant && $configuration->seller_mozo)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            @if (isset($mozo_name) && $mozo_name)
                                {{ $mozo_name }}
                            @endif
                        </td>
                    </tr>
                @endif

                @if ($is_restaurant)
                    <tr>
                        <td colspan="4" class="header_title1 text-center" valign="top">
                            USUARIO: {{ join(', ', $users) }}
                        </td>
                    </tr>
                @endif

                @if (!$precuenta)
                    @if (count($to_carry) != 0)
                        {{-- <tr>
                        <th class="encabezado text-center header_title2" colspan="4">Para llevar </th>
                    </tr> --}}
                        <tr class="para-llevar-header">
                            <th class="" colspan="4" style="color: rgb(10, 0, 0);">Para
                                llevar </th>
                        </tr>
                    @endif
                @endif

                <!-- Table headers with conditional widths -->
                <tr>
                    <td width="10%" class="cell_number encabezado" style="font-size: 18px !important;">
                        <strong>#</strong>
                    </td>
                    @if ($to_kitchen)
                        <!-- Kitchen view with price columns -->
                        <td width="60%" class="encabezado text-center" style="font-size: 18px !important;">
                            <strong>PRODUCTO</strong>
                        </td>
                        <td width="15%" class="encabezado text-center" style="font-size: 18px !important;">
                            <strong>IMP.</strong>
                        </td>
                        <td width="15%" class="encabezado text-center" style="font-size: 18px !important;">
                            <strong>SUB.</strong>
                        </td>
                    @else
                        <!-- Comanda view with wider product column -->
                        {{-- <td width="90%" colspan="3" class="encabezado text-center"
                        style="font-size: 18px !important;">
                        <strong>PRODUCTO</strong>
                    </td> --}}
                    @endif
                </tr>

                <!-- Table content with conditional widths -->
                <tbody>
                    @foreach ($orden_items as $row)
                        <tr>
                            <td width="10%" class="text-center" style="font-size: 16px !important;">
                                {{ $row->quantity }}
                            </td>
                            @if ($to_kitchen)
                                <!-- Kitchen view layout -->
                                <td width="60%" class="celda_left header_title2 border-bottom"
                                    style="font-size: 16px !important;">
                                @else
                                    <!-- Comanda view layout -->
                                <td width="90%" colspan="3" class="celda_left header_title2 border-bottom"
                                    style="font-size: 24px !important;">
                            @endif
                            <strong>
                                {{ strtoupper($row->desc_unit) }}
                                @if ($row->food->item->second_name && $configuration->show_second_name_external_code)
                                    / {{ strtoupper($row->food->item->second_name) }}
                                @endif
                            </strong>
                            @if ($row->observations != '-')
                                <br>
                                <strong style="font-size: 14px !important;">
                                    Obs: {{ e($row->observations) }}
                                </strong>
                            @endif
                            </td>
                            @if ($to_kitchen)
                                <td width="15%" class="celda_center" style="font-size: 16px !important;">
                                    {{ number_format($row->price, 2) }}
                                </td>
                                <td width="15%" class="celda_center" style="font-size: 16px !important;">
                                    {{ number_format($row->price * $row->quantity, 2) }}
                                </td>
                            @endif
                        </tr>
                        {{-- @if ($establishment && $establishment->image_yape)
                            <tr>
                                <td colspan="4" class="text-center">
                                    <img src="{{ public_path('storage/uploads/logos/' . $establishment->image_yape) }}"
                                        alt="payment-logo" style="max-width: 150px; height: auto;" />
                                </td>
                            </tr>
                        @endif --}}
                    @endforeach
                </tbody>
            </table>

            <!-- Make footer text larger -->
            @if ($to_kitchen && $configuration->text_comanda)
                <div class="text-center" style="width:75%">
                    @if ($configuration->text_one)
                        <label class="header_title0 bold" style="font-size: 18px !important;">
                            {{ mb_strtoupper($configuration->text_one) }}
                        </label>
                        <br>
                    @endif
                    @if ($configuration->text_two)
                        <label class="header_title0 bold" style="font-size: 18px !important;">
                            {{ mb_strtoupper($configuration->text_two) }}
                        </label>
                    @endif
                </div>
            @endif
        </div>
    @else
        {{-- Optional: Handle the case where none of the conditions are true --}}
        <div>
            <p>Debe activar una de las tres opciones de comandas para que pueda imprimir el contenido.</p>
        </div>
    @endif

</body>

</html>
