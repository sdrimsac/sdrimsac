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
                {{-- @if ($type_box == '1') --}}
                    <td width="40%" height="30" align="right" valign="middle"
                        style="font-size:13px !important;  font-family: sans-serif !important;">Movimiento Venta
                        {{-- Efectivo desde {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }} --}}
                        hasta {{ \Carbon\Carbon::parse($date_end)->format('d-m-Y') }}
                    </td>
                {{-- @else
                    <td width="40%" height="30" align="right" valign="middle"
                        style="font-size:13px !important;  font-family: sans-serif !important;">Reporte desde
                        {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}
                        hasta {{ \Carbon\Carbon::parse($date_end)->format('d-m-Y') }}
                    </td>
                @endif --}}
            
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
                    <strong>Fecha: </strong>{{ date('Y-m-d') }}
                </td>
                @if ($user)
                    <td class="headers">
                        <strong>Usuario: </strong>{{ $user->name }}
                    </td>
                @endif
            </tr>
            <tr class="nth-child">
                <td class="headers" height="20">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
                <td class="headers">
                    <strong>Establecimiento: </strong>{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }}
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>
    @if (!empty($boxes_report))
        <div class="">
            <div class=" ">
                @php
                    $totales_ingresos = 0;
                    $totales_egresos = 0;
                    $ingresos = 0;
                    $egresos = 0;
                    $depositos = 0;
                    $transferencia = 0;
                @endphp
                <table>
                    <tbody>


                        <tr>
                            <td class="encabezado">#</td>
                            <td class="encabezado" width="75">Fecha</td>
                            <td class="encabezado" width="65">Operacion</td>
                            <td class="encabezado" width="30">Ref</td>
                            <td class="encabezado" width="200">Cliente</td>
                            <td class="encabezado" width="200">Concepto</td>
                            <td class="encabezado" width="65">Monto</td>
                            <td class="encabezado" width="65">Usuario</td>

                        </tr>
                    <tbody>
                        @foreach ($boxes_report as $row)
                            <?php
                            if ($row['type'] == '1' && $row['method'] == 'Efectivo') {
                                $ingresos = $ingresos + $row['amount'];
                            }
                            if ($row['type'] == '1' && $row['method'] == 'Depositos') {
                                $depositos = $depositos + $row['amount'];
                            }
                            if ($row['type'] == '1' && $row['method'] == 'Transferencia') {
                                $transferencia = $transferencia + $row['amount'];
                            }

                            if ($row['type'] == '2') {
                                $egresos = $egresos + $row['amount'];
                            }
                            $date = \Carbon\Carbon::parse($row['date'])->format('d-m-Y')." ".\Carbon\Carbon::parse($row['created_at'])->format('h:m:s');
                            
                            if(isset($row["document_id"]) && $row["document_id"]!=null){
                                $document = \App\Models\Tenant\Document::find($row["document_id"]);
                                $date = $document->date_of_issue." ".$document->time_of_issue;
                            }
                            if(isset($row["sale_note_id"]) && $row["sale_note_id"]!=null){
                                $document = \App\Models\Tenant\SaleNote::find($row["document_id"]);
                                $date = $document->date_of_issue->format('Y-m-d')." ".$document->time_of_issue;
                            }
                            ?>
                            <tr>
                                <td class="celda_loop">{{ $loop->iteration }}</td>
                                <td class="celda_descrip">
                                    {{$date}}
                                </td>
                                @if ($row['type'] == '1' && $row['method'] == 'Transferencia')
                                    <td>Transferencia Bancaria</td>
                                @endif
                                @if ($row['type'] == '1' && $row['method'] == 'Efectivo')
                                    @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                                        <td class="celda_left">
                                            Ingreso
                                        </td>
                                    @else
                                        <td class="celda_left">
                                            Ingreso - Venta
                                        </td>
                                    @endif
                                @endif
                                @if ($row['type'] == '1' && $row['method'] == 'Deposito')
                                    <td class="celda_left">Deposito Bancario</td>
                                @endif
                                @if ($row['type'] == '1' && $row['method'] == 'Deposito')
                                    <td class="celda_left">Deposito Bancario</td>
                                @endif
                                @if ($row['type'] == '1' && $row['method'] == 'Transferencia')
                                   <td class="celda_left">Transferencia Bancario</td>
                                @endif
                                @if ($row['type'] == '1' && $row['method'] == 'YAPE')
                                    <td class="celda_left">YAPE</td>
                                 @endif
                                @if ($row['type'] == '1' && $row['method'] == 'PLIN')
                                     <td class="celda_left">PLIN</td>
                                @endif
                                @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                        <td class="celda_left">
                                            Egresos - Gastos
                                        </td>
                                @endif
                                    <td class="celda_left">{{$row["cash"]["reference_number"]}}</td>
                                @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                    <td class="celda_left">
                                        {{ $row['subcategories']->subcategory }}
                                    </td>
                                @else
                                    @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                                        <td class="celda_left">
                                            {{ $row['subcategories']->subcategory }}
                                        </td>
                                    @else
                                        @if ($row['sale_note_id'] != null && $row['document_id'] == null)
                                            <td class="celda_left">
                                                {{ $row['salenote']['customer']->name }}
                                            </td>
                                        @else
                                            @if ($row['sale_note_id'] != null && $row['document_id'] != null)
                                                <td class="celda_left">
                                                    {{ $row['salenote']['customer']->name }}
                                                </td>
                                            @else
                                                @if ($row['document_id'] != null && $row['sale_note_id'] == null)
                                                    <td class="celda_left">
                                                        {{ $row['document']['customer']->name }}
                                                    </td>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                                <td class="celda_left">{{ $row['description'] }}</td>
                                <td class="celda_date">{{ $row['amount'] }}</td>
                                <td class="celda_left">{{ $row['user']->name }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <table>
                    <tr>
                        <td class="categoria celda_right"><b>RESUMEN DE ARQUEO</b></td>
                    </tr>

                    <tr>
                        <td class="categoria celda_right">Ingresos - Venta : <b> S/.
                                {{ number_format(round($ingresos * 10) / 10, 2) }}</b></td>
                    </tr>
                    <tr>
                        <td class="categoria celda_right">Egresos : <b> S/.
                                {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                    </tr>



                    @if ($type_box == '2' && $type_box != null)
                        <tr>
                            <td class="categoria celda_right">Gastos - Egresos : <b> S/.
                                    {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                    @if ($depositos > 0.0 || $transferencia > 00)
                        <tr>
                            <td class="categoria celda_right">Depositos - Transferencia : <b> S/.
                                    {{ number_format(round(($depositos + $transferencia) * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                    @if ($type_box == '1' && $type_box != null)
                        <tr>
                            <td class="categoria celda_right">Totales : <b> S/.
                                    {{ number_format($ingresos - $egresos + $depositos + $transferencia, 2) }}</b>
                            </td>
                        </tr>
                        @if ($type_box == '2' && $type_box != null)
                            <tr>
                                <td class="categoria celda_right">Efectivo Gastos: <b> S/.
                                        {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                            </tr>
                        @endif
                    @endif
                    @if ($type_box == '1' && $type_box != null)
                        <tr>
                            <td class="categoria celda_right">Efectivo : <b> S/.
                                    {{ number_format(round(($egresos + $ingresos) * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>

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
