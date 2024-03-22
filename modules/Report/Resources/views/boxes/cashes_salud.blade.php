<!DOCTYPE html>
<html lang="en">
@php
    // $company = \App\Models\Company::select('health_network_image')->first();

@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {}

        .table {
            border: 0.1px solid #ccc;
        }

        .celda {
            text-align: left;
            padding: 2px;
            border: 0.1px solid #ccc;
        }

        .celda_center {
            text-align: center;
            padding: 2px;
            border: 0.1px solid #ccc;
        }

        .celda_right {
            text-align: right;
            padding: 2px;
            border: 0.1px solid #ccc;
        }

        tr:nth-child(even) {}

        .nth-child {
            background-color: transparent;
        }

        .border-bottom {
            border-bottom: 0.1px solid #ccc;
        }

        td {
            padding: 2px;
        }

        th {
            padding: 5px;
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid #ccc;
        }

        .headers {
            padding: 2px !important;
            border-bottom: 0.1px solid #ccc;
            height: 15px;
            font-size: 14px !important;
        }

        .title {
            font-weight: bold;
            padding: 2px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        p>strong {
            margin-left: 2px;
            font-size: 10px;
        }

        thead {
            font-weight: bold;
            color: #000;
            text-align: center;
        }

        .title {
            font-weight: bold;
            padding: 3px;
            font-size: 15px !important;
            text-decoration: underline;
        }

        .encabezado {
            background-color: #ccc;
            text-transform: uppercase;
            text-align: center
        }

        .categoria {
            background-color: #eee;
            text-transform: uppercase;
        
        }

        .celda_loop {
            width: 10% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_descrip {
            width: 80% !important;
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_date {
            width: 30% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
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

        @page {
            margin: 0cm 0.5cm 0.5cm 0.5cm;
            font-family: sans-serif;
        }

        /* td {
            border-bottom: 1px solid #ccc;
        } */

        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }

        body {
            margin: 0.5cm 0.5cm 0.5cm 0.5cm;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    @if($company->health_network_image &&  file_exists(public_path("storage/uploads/logos/{$company->health_network_image}")))
    <div >
        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->health_network_image}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->health_network_image}"))) }}"
        alt="{{ $company->health_network_image }}" 
        style="max-width: 230px;">
    </div>
    @endif
    <div style="font-size:15px;">
        <strong>MINISTERIO DE SALUD</strong><br>
        <strong>{{ $company->name }}</strong><br>
    </div>

    {{-- <div>
        <table cellpadding="0" cellspacing="0"
            style="border-collapse: collapse;border:1px solid #ddd; margin-top: 10px !important;">
            <tr>
                <td class="headers" height="20">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="headers">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
            </tr>
        </table>
    </div> --}}
    <div class="text-center"
        style="text-decoration: underline; margin-top: 10px !important; margin-bottom: 10px !important;
    font-size:14px;
    ">
        <strong>
            RELACION TABULADA DE INGRESOS DIARIOS
        </strong>
    </div>
    <table>
        <tr>
            <td>
                <strong>FECHA:</strong>
                {{ \Carbon\Carbon::parse($cash->date_opening)->format('d/m/Y') }}
            </td>
            <td>
                <strong>RESPONSABLE:</strong>
                {{ $cash->user->name }}
            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th colspan="5">
                    DOCUMENTOS
                </th>
            </tr>
            <tr>
                <th></th>
                <th>SERIE</th>
                <th>DEL</th>
                <th>AL</th>
                <th>TOTAL S/</th>
            </tr>
        <tbody>
            @if (isset($info_documents['min_03']) || isset($info_documents['max_03']))
                <tr>

                    <td class="celda">BV-{{ $establishment->description }}</td>
                    <td class="celda text-center">
                        @if (isset($info_documents['min_03']))
                            {{ $info_documents['min_03']->series }}
                        @endif
                    </td>
                    <td class="celda text-center">
                        @isset($info_documents['min_03'])
                            {{ $info_documents['min_03']->number }}
                        @endisset
                    </td>
                    <td class="celda text-center">
                        @isset($info_documents['max_03'])
                            {{ $info_documents['max_03']->number }}
                        @endisset
                    </td>
                    <td class="celda text-end">
                        @isset($info_documents['total_03'])
                            {{ number_format($info_documents['total_03'], 2) }}
                        @endisset
                    </td>
                </tr>
            @endif
            @if (isset($info_documents['min_01']) || isset($info_documents['max_01']))
                <tr>
                    <td class="celda">FT-{{ $establishment->description }}</td>
                    <td class="celda text-center">
                        @isset($info_documents['min_01'])
                            {{ $info_documents['min_01']->series }}
                        @endisset

                    </td>
                    <td class="celda text-center">
                        @isset($info_documents['min_01'])
                            {{ $info_documents['min_01']->number }}
                        @endisset
                    </td>
                    <td class="celda text-center">
                        @isset($info_documents['max_01'])
                            {{ $info_documents['max_01']->number }}
                        @endisset
                    </td>
                    <td class="celda text-end">
                        @isset($info_documents['total_01'])
                            {{ number_format($info_documents['total_01'], 2) }}
                        @endisset
                    </td>
                </tr>
            @endif
            @if ($cash->pharmacy_info)
                @php
                    $info = (array) $cash->pharmacy_info;
                @endphp
                @foreach ($info as $key => $value)
                    @if (isset($value->serie_bv))
                        <tr>
                            <td class="celda">BV-{{ $value->pharmacy_name }}</td>
                            <td class="celda text-center">
                                {{ $value->serie_bv }}
                            </td>
                            <td class="celda text-center">
                                {{ $value->min_bv }}
                            </td>
                            <td class="celda text-center">
                                {{ $value->max_bv }}
                            </td>
                            <td class="celda text-end">
                                {{ number_format($value->total_bv, 2) }}
                            </td>
                        </tr>
                    @endif
                    @if (isset($value->serie_ft))
                        <tr>
                            <td class="celda">FT-{{ $value->pharmacy_name }}</td>
                            <td class="celda text-center">
                                {{ $value->serie_ft }}

                            </td>
                            <td class="celda text-center">
                                {{ $value->min_ft }}
                            </td>
                            <td class="celda text-center">
                                {{ $value->max_ft }}
                            </td>
                            <td class="celda text-end">
                                {{ number_format($value->total_ft, 2) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
        </thead>

    </table>
    <table width="100%" cellpadding="0" cellspacing="0"
        style="border-collapse: collapse; border:1px solid #ddd; margin-top: 10px !important;">
        <thead>
            <tr>
                <th class="encabezado">Código</th>
                <th class="encabezado">Concepto</th>
                <th class="encabezado">Subtotal</th>
                <th  class="encabezado">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_general = 0;
            @endphp
            @foreach ($items_by_category as $category => $items)
                @php
                    $barcode = reset($items)['barcode'];
                    $cat = \Modules\Item\Models\PrincipalCategory::where('identifier', $barcode)->first();
                    $is_expanded = true;
                    if ($cat) {
                        $is_expanded = $cat->is_expanded;
                    }
                @endphp
                <tr>
                    <td class="categoria celda">
                        {{ $barcode }}
                    </td>
                    <td class="categoria ">{{ $category }}</td>
                    <td class="categoria celda"></td>
                    @php
                        $category_sum = array_sum(array_column($items, 'total'));
                        $total_general += $category_sum;
                    @endphp

                    <td  class="categoria celda text-end">{{ number_format($category_sum, 2) }}</td>
                </tr>
                @if ($is_expanded)
                    @foreach ($items as $item)
                        <tr>
                            <td class="celda_loop"></td>
                            <td class="celda_descrip">{{ $item['description'] }}</td>
                            <td class="celda_loop text-end">{{ number_format($item['total'], 2) }}</td>
                            <td class="celda_date"></td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
            <tr>
                <td class="celda_loop" colspan="2"></td>
                <td class="text-end celda_loop">
                    <strong>Total General</strong>
                </td>
                <td class="celda_date text-end
                    ">
                    <strong>{{ number_format($total_general, 2) }}</strong>
                </td>
            </tr>
        </tbody>
    </table>

</body>


</html>
