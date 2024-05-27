<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid #ccc;
        }

        .table {
            border: 0.1px solid #ccc;
        }

        .celda {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_center {
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_right {
            text-align: right;
            padding: 5px;
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
            /* padding: 5px; */
        }

        th {
            /* padding: 5px; */
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid #ccc;
        }

        .headers {
            /* padding: 5px !important */
            border-bottom: 0.1px solid #ccc;
            height: 25px;
            font-size: 14px !important;
        }

        .title {
            font-weight: bold;
            /* padding: 5px; */
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

        .title {
            font-weight: bold;
            padding: 3px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        .encabezado {
            background-color: #ccc;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 10px;
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
            border: 0.1px solid #ccc;
        }

        .celda_left {
            width: 30% !important;
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_descrip {
            width: 60% !important;
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

        .center {
            text-align: center;
        }

        @page {
            margin: 0.5cm 0.5cm 0cm 0.5cm;
            font-family: sans-serif;
        }

        td {
            border-bottom: 1px solid #ccc;
        }

        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }

        body {
            margin: 0.5cm 0.5cm 0.5cm 0.5cm;
        }
    </style>
</head>
<!--  reporte de habitaciones  -->

<body>
    <table>
        <div style="margin-top:5px; margin-bottom:3px;">
            <table>
                <tr>
                    <td colspan="5" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                        @php
                        $title = $filter_type == 1 ? 'Reporte por de habitaciones por clientes' : 'Reporte de habitaciones';
                        @endphp
                        <h3 class="title"><strong>{{ $title }}</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa:</strong>{{ $company->name }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong>{{ $company->number }}</p>
                    </td>
                    <td colspan="3" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong> {{ $date_start == $date_end ? $date_start : $date_start . ' - ' . $date_end }}</p>
                    </td>

                </tr>
            </table>
        </div>
        <br>
        @if (!empty($records))

        <div class="">
            <div class=" ">
                <table width="100%" class="">
                    <thead>
                        {{-- <tr>
                            <td class="encabezado">#</td>
                            <td class="encabezado">Fecha</td>
                            <td class="encabezado">Operacion</td>
                             <td class="encabezado">Concepto</td>
                            <td class="encabezado">Monto</td>
                            <td class="encabezado">Usuario</td> --}}
                        <tr>
                            <td class="encabezado" >#</td>

                            @if ($filter_type == 1)
                            <td class="encabezado" >Cliente</td>
                            <td class="encabezado" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Documento</td>
                            @else
                            <td class="encabezado" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Habitacion</td>
                            @endif

                            <td class="encabezado center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">N° de veces</td>
                            <td class="encabezado center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Dias de alquiler</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $row)
                        @php
                        if ($filter_type == 1) {
                        $value = [
                        'item_count' => $row->item_count,
                        'customer_id' => $row->customer_id,
                        'customer_name' => $row->customer->name,
                        'customer_number' => $row->customer->number,
                        'total_duration' => $row->total_duration,
                        ];
                        } else {
                        $value = [
                        'item_count' => $row->item_count,
                        'table_id' => $row->table_id,
                        'total_duration' => $row->total_duration,
                        'name' => "$row->table_name - $row->floor_name - $row->tower_name",
                        ];
                        }
                        @endphp
                        <tr>
                            <td class="celda_loop" style="border: 2px solid black; text-align: center;">{{ $loop->iteration }}</td>
                            @if ($filter_type == 1)
                            <td class="celda_left" style="border: 2px solid black; text-align: center;">
                                {{ $value['customer_name'] }}
                            </td>
                            <td class="celda_left" style="border: 2px solid black; text-align: center;">{{ $value['customer_number'] }}</td>
                            @else
                            <td class="celda_left
                                    " style="border: 2px solid black; text-align: center;">{{ $value['name'] }}
                            </td>
                            @endif
                            <td class="celda_center" style="border: 2px solid black; text-align: center;">{{ $value['item_count'] }}</td>
                            <td class="celda_center" style="border: 2px solid black; text-align: center;">{{ $value['total_duration'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    </table>
    @else
    <div class="callout callout-info">
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>