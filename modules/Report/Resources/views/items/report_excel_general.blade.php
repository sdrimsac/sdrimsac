@php
$warehouses = App\Models\Tenant\Warehouse::all();
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    html {
        font-family: sans-serif;
        font-size: 11px;
    }

    .border_header td {
        border-bottom: 0.1px solid #ccc !important;
        padding: 3px !important;
    }

    .border_header {
        border: 0.1px solid #ccc !important;


    }

    table {
        width: 98%;
        border-right: 0.1px solid #ccc !important;

    }

    .center {
        text-align: center !important;


    }

    .right {
        border-right: 0.1px solid #ccc;
    }

    .celda {
        text-align: left;
        padding: 3px;
        border: 0.1px solid #ccc;
    }

    th {
        padding: 3px;
        text-align: center;
        border-color: #409EFF;
        border: 0.1px solid #ccc;
    }

    .title {
        font-weight: bold;
        padding: 3px;
        font-size: 20px !important;
        text-decoration: underline;
    }

    p>strong {
        margin-left: 5px;
        font-size: 13px;
    }

    thead {
        font-weight: bold;
        color: #000;
        text-align: center;
    }

    .headers {
        padding: 5px !important;
        border-bottom: 0.1px solid #ccc;
    }

    @page {
        margin: 0cm 0.5cm 0cm 0.5cm;
        font-family: Arial;
    }

    body {
        margin: 1.5cm 0.5cm 0.5cm 0.5cm;
    }
</style>

<body>
    <table>
        <div style="margin-top:5px; margin-bottom:5px;">
            <table style="border-right:0px !important;" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="10" class="headers" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px; font-weight: bold;">
                        <strong>REPORTE DE PRODUCTOS</strong>
                    </td>
                </tr>
                <tr>
                    <td class="headers" colspan="7" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Empresa: </strong>{{ $company->name }}</p>
                    </td>
                    <td class="headers" colspan="3" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <!-- <strong>Fecha: </strong>{{ date('Y-m-d') }} -->
                        <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                    </td>
                </tr>
                <tr>
                <td class="headers" colspan="7" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Establecimiento: </strong>{{ $establishment->address }} -
                            {{ $establishment->department->description }} - {{ $establishment->district->description }}
                        </p>
                    </td>
                    <td class="headers" colspan="3" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Ruc: </strong>{{ $company->number }}</p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        @if (!empty($records))
        @php
        $acum_total_taxed = 0;
        $acum_total_igv = 0;
        $acum_total = 0;

        $serie_affec = '';
        $acum_total_exonerado = 0;
        $acum_total_inafecto = 0;

        $acum_total_free = 0;

        $acum_total_taxed_usd = 0;
        $acum_total_igv_usd = 0;
        $acum_total_usd = 0;
        $acum_quantity = 0;
        @endphp
        <div class="">
            <div class=" ">

                <table cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Codigo Interno</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Producto</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Código de barras</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Unidad de medida</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Categoría</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Marca</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Precio de Compra</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Precio de Venta</th>
                            {{-- @foreach ($warehouses as $warehouse )
                                   <th class="right">{{$warehouse->description}}</th>
                            @endforeach --}}
                            <th class="right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                        <tr>
                            <td class="celda center" style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>

                            <td class="celda center" style="border: 2px solid black; text-align: center;">{{ $value->internal_id }}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{ $value->description }}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{ $value->barcode }}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{ $value->unit_type_id }}</td>

                            <td class="celda" style="border: 2px solid black; text-align: center;">{{ $value->category ? $value->category->name :''}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{ $value->brand ? $value->brand->name : '' }}</td>
                            <td class="celda center" style="border: 2px solid black; text-align: center;">{{ $value->purchase_unit_price }}</td>
                            <td class="celda center" style="border: 2px solid black; text-align: center;">{{ $value->sale_unit_price }}</td>
                            {{-- @foreach ($warehouses as $warehouse )
                                <td></td>
                                @endforeach --}}
                            <td class="celda center" style="border: 2px solid black; text-align: center;">
                                {{ $value->stock }}
                            </td>

                        </tr>
                        @php

                        $acum_quantity++;

                        @endphp
                        @endforeach
                        {{-- <tr>
                            <td class="celda" colspan="4"></td>
                            <td class="celda center"><b>Total de Productos</b></td>
                            <td class="celda center"><b>{{ $acum_quantity }}</b></td>
                        <td></td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </table>
    @else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>