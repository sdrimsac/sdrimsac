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
            /* padding: 5px; */
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
            padding: 5px;
            border: 0.1px solid #000;
        }

        .celda_sm {
            text-align: center;
            height: 25px;

            font-size: 7px !important;
            border: 0.1px solid #000;
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
            /* margin: 15px; */
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

        .border-rounded {
            border-radius: 10px;
            border: 1px solid #000;
            padding: 5px;
            min-height: 150px;
        }

        .btr {
            border-top-right-radius: 10px;
        }

        .btl {
            border-top-left-radius: 10px;
        }

        .bbr {
            border-bottom-right-radius: 10px;
        }

        .bbl {
            border-bottom-left-radius: 10px;
        }
    </style>

<body>
    @php
        $count = ($page - 1) * 32;

    @endphp
    {{-- @if ($sale->status !== 'A' && $sale->status !== null)
        <div class="company_logo_box"
            style="position: absolute; text-align: center; top:30%;
    left: 0; right: 0; margin: auto; width: 100%; height: 100px;
    color: red; font-size: 50px; font-weight: bold; font-family: Arial, sans-serif;
    transform: rotate(-45deg); -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg); -o-transform: rotate(-45deg); -ms-transform: rotate(-45deg);
    opacity: 0.3; filter: alpha(opacity=10); z-index: -1;
">
            SIN VALOR LEGAL
        </div>
    @endif --}}
    <table class="full-width ">
        <tr>
            <td width="20%" class="text-center">INTERES
                <br>
                <div class="border-rounded">
                    {{ $tasa }}%
                </div>
            </td>
            <td width="20%" class="text-center">DIAS A COBRAR
                <br>
                <div class="border-rounded">
                    {{ $days }}
                </div>

            </td>
            <td width="60%" class="title text-centerb">
                TARJETA DE CONTROL
            </td>
        </tr>
    </table>
    <table class="full-width border-rounded">
        <tr>
            <td colspan="2">
                <strong>CLIENTE:</strong>
                {{ $sale->customer->name }}
            </td>

        </tr>
        <tr>
            <td colspan="2">
                <strong>DIRECCION:</strong>
                @if ($sale->customer->address)
                    {{ $sale->customer->address }}
                @else
                    _________________________________________________________________
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <strong>DNI:</strong>
                {{ $sale->customer->number }}
            </td>
            <td>
                <strong>CELULAR:</strong>
                @if ($sale->customer->telephone)
                    {{ $sale->customer->telephone }}
                @else
                    _________________________________________________________________
                @endif
            </td>

        </tr>
        <tr>
            <td colspan="2">
                <strong>NEGOCIO:</strong>
                _________________________________________________________________
            </td>
        </tr>
    </table>
    @php
        $item = null;
        if (count($sale->items) == 1) {
            $item = $sale->items[0];
        }

    @endphp
    <table style="" class="full-width">
        <td width="40%">
            <table class="full-width">
                <tr>
                    <td width="49%" class="text-center">
                        <strong>PRODUCTO</strong>
                        <div class="border-rounded">
                            @if ($item)
                                {{ $item->item->description }}
                            @else
                                <br>
                            @endif
                        </div>
                    </td>
                    <td></td>
                    <td width="49%" class="text-center">
                        <strong>MARCA</strong>
                        <div class="border-rounded">
                            @if (isset($item->item->brand_id) && $item->item->brand_id != null)
                                @php
                                    $brand = \Modules\Item\Models\Brand::find($item->item->brand_id);
                                @endphp
                                {{ $brand->name }}
                            @else
                                <br>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="49%" class="text-center">

                        <div class="border-rounded">
                            <div style="border-bottom: 1px solid #000;">

                                <strong>SALDO</strong>
                            </div>
                            <br>
                        </div>
                    </td>
                    <td></td>
                    <td width="49%" class="text-center">

                        <div class="border-rounded">
                            <div style="border-bottom: 1px solid #000;">
                                <strong>PAGO {{ strtoupper($sale->type_payment) }}</strong>

                            </div>
                            <div>
                                {{ $quote }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>

                    <table>
                        <thead>
                            <tr>
                                <th class="celda btl">N°</th>
                                <th class="celda" width="10%">FECHA</th>
                                <th class="celda">CUOTA</th>
                                <th class="celda">
                                    AMORT.
                                </th>
                                <th class="celda">MORA</th>
                                <th class="celda btr">FIRMA</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for ($i = $count; $i <= $count + 15; $i++)
                                @php
                                    $idx = $i;
                                @endphp
                                @if (isset($data[$idx]))
                                    <tr>
                                        <td class="celda_sm">{{ $i + 1 }}</td>
                                        <td class="celda_sm">
                                            {{ \Carbon\Carbon::parse($data[$idx]['date_payment'])->format('d/m/y') }}
                                        </td>
                                        <td class="celda_sm">
                                            {{ number_format($data[$idx]['amount'], 2) }}
                                        </td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="celda_sm">
                                            {{ $i + 1 }}

                                        </td>
                                        <td class="celda_sm">
                                            <br>
                                        </td>
                                        <td class="celda_sm">
                                            <br>
                                        </td>
                                        <td class="celda_sm">
                                            <br>
                                        </td>
                                        <td class="celda_sm">
                                            <br>
                                        </td>
                                        <td class="celda_sm">
                                            <br>
                                        </td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </tr>
            </table>
        </td>
        <td width="2%"></td>
        <td width="40%">
            <table class="full-width">
                <tr>
                    <td width="49%" class="text-center">
                        <strong>MODELO</strong>
                        <div class="border-rounded">
                            @php
                                $model = null;
                                if ($item) {
                                    $attributes = $item->item->attributes;
                                    if (count($attributes) > 0) {
                                        //search in array attributes the element with key 'description' 'Modelo'
                                        foreach ($attributes as $attribute) {
                                            if ($attribute->description == 'Modelo') {
                                                $model = $attribute;
                                            }
                                        }
                                    }
                                }
                            @endphp
                            @if ($model)
                                {{ $model->value }}
                            @else
                                <br>
                            @endif
                        </div>
                    </td>
                    <td></td>
                    <td width="49%" class="text-center">
                        <strong>SERIE</strong>
                        <div class="border-rounded">
                            @php
                                $serie = null;
                                $lots = $item->item->lots;
                                if (count($lots) > 0) {
                                    foreach ($lots as $lot) {
                                        if ($lot->selected == true) {
                                            $serie .= $lot->series . '-';
                                        }
                                    }
                                    $serie = substr($serie, 0, -1);
                                }
                            @endphp
                            @if ($serie)
                                {{ $serie }}
                            @else
                                <br>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="49%" class="text-center">

                        <div class="border-rounded">
                            <div style="border-bottom: 1px solid #000;">

                                <strong>
                                    FECHA INICIO</strong>

                            </div>
                            <div>
                                {{ $init_date }}
                            </div>
                        </div>
                    </td>
                    <td width="2%"></td>
                    <td width="49%" class="text-center">

                        <div class="border-rounded">
                            <div style="border-bottom: 1px solid #000;">
                                <strong>
                                    FECHA FINAL
                                </strong>


                            </div>
                            <div>
                                {{ $end_date }}
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>

                    <table>
                        <thead>
                            <tr>
                                <th class="celda btl">N°</th>
                                <th class="celda" width="10%">FECHA</th>
                                <th class="celda">CUOTA</th>
                                <th class="celda">AMORT.</th>
                                <th class="celda">MORA</th>
                                <th class="celda btr">FIRMA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = $count + 16; $i <= $count + 31; $i++)
                                @php
                                    $idx = $i;
                                @endphp
                                @if (isset($data[$idx]))
                                    <tr>
                                        <td class="celda_sm">{{ $i + 1 }}</td>
                                        <td class="celda_sm">
                                            {{ \Carbon\Carbon::parse($data[$idx]['date_payment'])->format('d/m/y') }}
                                        </td>
                                        <td class="celda_sm">
                                            {{ number_format($data[$idx]['amount'], 2) }}
                                        </td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="celda_sm">{{ $i + 1 }}</td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                        <td class="celda_sm"></td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </tr>
            </table>
        </td>
    </table>
    <br><br>
    <table class="full-width">
        <tr>
            <td class="text-center">
                <div class="border-rounded" style="font-size: 13px;font-weight: bold;text-transform: uppercase;">
                    {{ $establishment->address }}<br>
                    {{ $establishment->department->description }} - {{ $establishment->province->description }} -
                    {{ $establishment->district->description }}<br>
                    {{ $establishment->email }}<br>
                    {{ $establishment->telephone }}
                </div>

            </td>
        </tr>
    </table>
</body>
