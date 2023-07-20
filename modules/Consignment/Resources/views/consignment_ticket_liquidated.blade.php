<?php
use Illuminate\Support\Facades\Session;
use App\Models\Tenant\Company;
use App\Models\Tenant\Turned;
?>
@php
    
@endphp
<html>

<head>
    {{-- <title>{{ $tittle }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
    <style>
        html {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-spacing: 0;

        }
        .mini{
        font-size: 7px !important;
    }
    .mini2{
        font-size: 8px !important;
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
            /* height: 15px; */
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
    </style>
</head>

<body>

    @if ($company->logo)
        <div class="text-center company_logo_box">
            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                alt="{{ $company->name }}" class="company_logo_ticket contain">
        </div>
    @else
        <img src="data:{{ mime_content_type('logo/logo.jpg') }};base64, {{ base64_encode(file_get_contents('logo/logo.jpg')) }}"
            class="company_logo_ticket contain">
    @endif
    <table class="full-width">
        <tr>
            <td class="text-center mini2">
                <h4>{{ $company->eslogan }}</h4>
            </td>
        </tr>
        <tr>
            <td class="text-center mini2">
                <h5>{{ 'RUC ' . $company->number }}</h5>
            </td>
        </tr>
        <tr>
            <td class="text-center mini2">
                {{ $establishment->address !== '-' ? $establishment->address : '' }}
                {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
            </td>
        </tr>
        <tr>
            <td class="text-center mini2">{{ $establishment->email !== '-' ? $establishment->email : '' }}</td>
        </tr>
        <tr>
            <td class="text-center pb-3 mini2">{{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}</td>
        </tr>
        <tr>
            <td class="text-center border-top mini2">
                <h4>CONSIGNACION (liquidada)</h4>
            </td>
        </tr>
        <tr>
            @php
                use Carbon\Carbon;
                $number = str_pad($consignment->id, 8, '0', STR_PAD_LEFT);
            @endphp
            <td class="text-center pb-3 border-bottom mini2">
                <h3>{{ $number }}</h3>
            </td>
        </tr>
    </table>
    <table class="full-width">
        <tr>
            <td width="" class="">
                <p class="mini2">F. Consignación:</p>
            </td>
            <td width="" class="">
                <p class="dmini2emini2sc">{{ Carbon::parse($consignment->date_of_issue)->format('d-m-Y') }}</p>
            </td>
        </tr>
        <tr>
            <td width="">
                <p class="mini2">F. Liquidación:</p>
            </td>
            <td width="">
                <p class="mini2">{{ Carbon::parse($consignment->date_of_end)->format('d-m-Y') }}</p>
            </td>
        </tr>

        <tr>
            <td class="align-top">
                <p class="mini2">Cliente:</p>
            </td>
            <td>
                <p class="mini2">{{ $customer->name }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="mini2">{{ $customer->identity_document_type->description }}:</p>
            </td>
            <td>
                <p class="mini2">{{ $customer->number }}</p>
            </td>
        </tr>
        @if ($customer->address !== '')
            <tr>
                <td class="align-top">
                    <p class="mini2">Dirección:</p>
                </td>
                <td>
                    <p class="mini2">
                        {{ $customer->address }}
                        {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                        {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                        {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                    </p>
                </td>
            </tr>
        @endif


    </table>
    @php
        $has_selled = $items->where('selled_quantity', '<', $items->sum('selled_quantity'))->count() > 0;
    @endphp
    @if ($has_selled)
        <table class="full-width mt-10 mb-10">
            <thead class="">
                <tr>
                    <th class="border-top-bottom  text-left mini">CANT.</th>
                    <th class="border-top-bottom  text-left mini">UNIDAD</th>
                    <th class="border-top-bottom  text-left mini">DESCRIPCIÓN</th>
                    <th class="border-top-bottom  text-left mini">P.UNIT</th>
                    <th class="border-top-bottom  text-left mini">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    @if ($item->selled_quantity > 0)
                        <tr>
                            <td class="text-center mini align-top">
                                {{ $item->original_quantity }}
                            </td>
                            <td class="text-center mini align-top">{{ $item->item->unit_type_id }}</td>
                            <td class="text-left mini align-top">

                                {!! $item->item->description !!}

                            </td>
                            <td class="text-right mini align-top">{{ number_format($item->price, 2) }}</td>
                            <td class="text-right mini align-top">
                                {{ number_format($item->price * $item->original_quantity, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="border-bottom"></td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    @endif
    @php
        $has_returned = $items->where('return_quantity', '<', $items->sum('return_quantity'))->count() > 0;
    @endphp
    @if ($has_returned)
        <br>
        <table class="full-width mt-10 mb-10">
            <thead class="">
                <tr>
                    <th colspan="3" class="mini">
                        PRODUCTOS DEVUELTOS

                    </th>
                </tr>
                <tr>
                    <th class="border-top-bottom mini text-left">CANT.</th>
                    <th class="border-top-bottom mini text-left">UNIDAD</th>
                    <th class="border-top-bottom mini text-left">DESCRIPCIÓN</th>
                    {{-- <th class="border-top-bottom mini text-left">P.UNIT</th> --}}
                    {{-- <th class="border-top-bottom mini text-left">TOTAL</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    @if ($item->return_quantity > 0)
                        <tr>
                            <td class="text-center mini align-top">
                                {{ $item->return_quantity }}
                            </td>
                            <td class="text-center mini align-top">{{ $item->item->unit_type_id }}</td>
                            <td class="text-center mini align-top">

                                {!! $item->item->description !!}

                            </td>
                            {{-- <td class="text-right mini align-top">{{ number_format($item->price, 2) }}</td>
                            <td class="text-right mini align-top">
                                {{ number_format($item->price * $item->return_quantity, 2) }}</td> --}}
                        </tr>
                        <tr>
                            <td colspan="5" class="border-bottom"></td>
                        </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    @endif
    <br>
    <table class="full-width">
            <tr>
                <td align="center">
                    <small class="mini">
                      Esta consignación ha sido liquidada
                    </small>
                </td>
            </tr>
    </table>

</body>

</html>
