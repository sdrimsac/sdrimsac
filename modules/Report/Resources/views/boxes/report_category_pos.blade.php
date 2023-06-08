<!DOCTYPE html>
<html lang="en">

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

        table {
            width: 100%;
            border-spacing: 0;

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

        th {
            padding: 5px;
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid #ccc;
        }

        .headers {
            padding: 5px !important;
            border-bottom: 0.1px solid #ccc;
            height: 25px;
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
            padding: 5px;
            font-size: 12px !important;
        }

        .encabezado {
            background-color: #eee;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 10px;
            font-weight: bold;
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

        .celda_left {
            width: 30% !important;
            text-align: left;
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

        .grupo {
            padding-left: 20px;
        }

        .categoria {
            padding-left: 60px;
        }

        .subcategoria {
            padding-left: 100px;
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
            margin: 0.5cm 0.5cm 0cm 0.5cm;
            font-family: sans-serif;
        }

        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }

        body {
            margin: 1.5cm 0.5cm 0.5cm 0.5cm;
        }

    </style>
</head>

<body>
    <header>
        <table style="border-collapse: collapse;border-bottom:1px solid #ddd;">
            <tr>
                <td width="60%" height="30" align="left" valign="top">
                    @if ($company->logo)
                        <img src="{{ asset('storage/uploads/logos/' . $company->logo) }}" height="40" />
                    @endif
                </td>
                <td width="40%" height="30" align="right" valign="middle"
                    style="font-size:13px !important;  font-family: sans-serif !important;">
                    Reporte desde {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}
                    hasta {{ \Carbon\Carbon::parse($date_end)->format('d-m-Y') }}
                </td>
            </tr>
        </table>
    </header>

    <div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="headers" height="20">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="headers">
                    <strong>Establecimiento: </strong>{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }}
                </td>
                @if ($user)
                    <td class="headers">
                        <strong>Usuario: </strong>{{ $user->name }}
                    </td>
                @endif

            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>

    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php
                    $total_ingresos = 0;
                    $total_egresos = 0;
                    $ingresos = 0;
                    $egresos = 0;
                    $depositos = 0;
                    $transferencia = 0;
                @endphp
                <table width="100%" class="table">

                    <tbody>
                        @foreach ($records as $group)
                            <tr>
                                <td colspan="7" class="encabezado grupo"> {{ $group['group_name'] }}</td>
                            </tr>
                            @foreach ($group['categories'] as $category)
                                <tr>
                                    <td colspan="7" class="encabezado categoria">{{ $category['category_name'] }}</td>
                                </tr>
                                @foreach ($category['subcategories'] as $subcategory)
                                    <tr>
                                        <td colspan="7" class="encabezado subcategoria">
                                            {{ $subcategory['subcategory_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="title celda_center" width="30px">#</td>
                                        <td class="title celda_center" width="100px">Usuario</td>
                                        <td class="title celda_center" width="80px">Operacion</td>
                                        <td class="title celda_center" width="160px">Cliente</td>
                                        <td class="title celda" width="280px">Concepto</td>
                                        <td class="title celda celda_center" width="100px">Fecha Hora de Pago</td>
                                        <td class="title celda_center" width="80px">Monto</td>
                                    </tr>
                                    <?php
                                    $monto_total = 0;
                                    ?>
                                    @foreach ($subcategory['rows'] as $row)
                                        <?php
                                        $monto_total = $monto_total + $row['monto'];
                                        if ($row['type'] == '1') {
                                            $total_ingresos = $total_ingresos + $row['monto'];
                                        }
                                        if ($row['type'] == '2') {
                                            $total_egresos = $total_egresos + $row['monto'];
                                        }
                                        ?>

                                        <tr>
                                            <td class="celda_center">{{ $loop->iteration }}</td>
                                            <td class="celda_center"> {{ $row['user'] }}</td>
                                            @if ($row['type'] == '1' && $row['method'] == 'Efectivo')
                                                @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                                                    <td class="celda_left">
                                                        Ingreso
                                                    </td>
                                                @else
                                                    <td class="celda_center">
                                                        Ingreso - Venta
                                                    </td>
                                                @endif
                                            @else
                                                @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                                    <td class="celda_center">
                                                        Egresos - Gastos
                                                    </td>
                                                @else
                                                    @if ($row['type'] == '1' && $row['method'] == 'Efectivo')
                                                        <td class="celda_center">

                                                        </td>
                                                    @endif
                                                @endif
                                            @endif

                                            <td class="celda_left">
                                                @if ($row['customer_salenote'] != '-' || $row['customer_document'] != '-')
                                                    @if ($row['customer_salenote'] != '-')
                                                        {{ $row['customer_salenote'] }}
                                                    @endif
                                                    @if ($row['customer_document'] != '-')
                                                        {{ $row['customer_document'] }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="celda_left">{{ $row['description'] }}</td>
                                            <td class="celda_center">{{ $row['date'] }}</td>
                                            <td class="celda_center">{{ $row['monto'] }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="celda_right title">Total S/.</td>
                                        <td class="celda_center title"> {{ number_format($monto_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                        <tr>
                            <td colspan="6" class="celda_right title">Total Ingreso S/.</td>
                            <td class="celda_center title"> {{ number_format($total_ingresos, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="celda_right title">Total Egresos S/.</td>
                            <td class="celda_center title"> {{ number_format($total_egresos, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="celda_right title">Total Efectivo S/.</td>
                            <td class="celda_center title"> {{ number_format($total_ingresos - $total_egresos, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <td align="center" style="font-size:18px !important">
                            <h1>No se encontraron registros.</h1>
                        </td>
                    </tbody>
                </table>

    @endif
    <footer>
        <table width="100%" border="0" style="border-collapse: collapse;border-top:1px solid #ddd;">
            <tr>
                <td align="left" valign="middle" colspan="2">Direccion:{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }} -
                    Telefonos: {{ $establishment->telephone }} Email: {{ $establishment->email }}</td>
            </tr>
        </table>
    </footer>
</body>


</html>
