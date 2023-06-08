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

        .celda_left {
            text-align: left;
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
            padding: 5px;
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
            font-size: 14px !important;
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

        td {
            border-bottom: 1px solid #ccc;
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
        <table style="border-collapse: collapse;border-bottom:1px solid #ddd;border:0px !important; ">
            <tr>

                <td width="50%" height="30" align="right" valign="middle"
                    style="font-size:13px !important;  font-family: sans-serif !important;border-bottom:1px solid #ccc">
                    Arqueso de Caja {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}
                </td>
            </tr>
        </table>
    </header>

    <div>
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

            <tr>
                @if ($user)
                    <td class="headers">
                        <strong>Usuario: </strong> {{ $user->name }}
                    </td>
                    <td class="headers">
                        <strong>Establecimiento: </strong>{{ $establishment->address }} -
                        {{ $establishment->department->description }} - {{ $establishment->district->description }}
                    </td>
                @else
                    <td colspan="2" class="headers">
                        <strong>Establecimiento: </strong>{{ $establishment->address }} -
                        {{ $establishment->department->description }} -
                        {{ $establishment->district->description }}
                    </td>
                @endif

            </tr>

        </table>
    </div>
    <table width="100%">
        <tr>
            <th class="headers" colspan="3" style="text-align:left !important;">PRODUCTOS VENDIDOS</th>
        </tr>
        <tr>
            <th>Cantidad</th>
            <th>Productos</th>

            <th>Importe</th>
        </tr>
        <tbody>
            <?php
            $total_cantidad = 0;
            $totales_sales = 0;
            ?>
            @foreach ($items as $row)
                <?php
                $total_cantidad = $total_cantidad + $row['quantity'];
                $totales_sales = $totales_sales + $row['total'];
                ?>
                <tr>
                    <td class="celda_center">{{ round($row['quantity']) }}</td>
                    <td>{{ $row['description'] }}</td>

                    <td class="celda_center">{{ $row['total'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="celda_right">TOTAL</td>

                <td class="celda_center">S/.{{ number_format($totales_sales, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table width="100%">
        <tr>
            <th class="headers" colspan="2" style="text-align:left !important;">VENTAS POR DOCUMENTO</th>
        </tr>
        <tr>
            <th>FACTURAS</th>
            <th>BOLETAS</th>
            <th>NOTAS DE VENTA</th>
        </tr>

        <body>
            <tr>
                <td class="celda_center">{{ $documents['facturas'] }}</td>
                <td class="celda_center">{{ $documents['boletas'] }}</td>
                <td class="celda_center">{{ $documents['notas'] }}</td>
            </tr>

            <tr>
                <td colspan="2" class="celda_right">TOTAL</td>
                <td class="celda_center">
                    S/.{{ number_format($documents['facturas'] + $documents['boletas'] + $documents['notas'], 2) }}
                </td>
            </tr>
        </body>
    </table>
    <table width="100%">
        <tr>
            <th class="headers" colspan="3" style="text-align:left !important;">GASTOS GENERADOS</th>
        </tr>
        <tr>
            <th>Nº</th>
            <th>Descripción</th>
            <th>Método</th>
            <th>Importe</th>
        </tr>
        <tbody>
            <?php
            $totales_expenses = 0;
            ?>
            @foreach ($expenses as $row_expenses)
                <?php
                $totales_expenses = $totales_expenses + $row_expenses->amount;
                ?>
                <tr>
                    <td class="celda_center">{{ $loop->iteration }}</td>
                    <td class="celda_left">{{ $row_expenses->description }}</td>
                    <td class="celda_left">{{ $row_expenses->method }}</td>
                    <td class="celda_center">{{ $row_expenses->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="celda_right">TOTAL</td>
                <td class="celda_center">S/.{{ number_format($totales_expenses, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tr>
            <th class="headers" colspan="3" style="text-align:left !important;">INGRESOS GENERADOS</th>
        </tr>
        <tr>
            <th>Nº</th>
            <th>Descripción</th>
            <th>Método</th>
            <th>Importe</th>
        </tr>
        <tbody>
            <?php
            $totales_incomes = 0;
            ?>
            @foreach ($dataingresos_all as $row_expenses)
                <?php
                $totales_incomes = $totales_incomes + $row_expenses->amount;
                ?>
                <tr>
                    <td class="celda_center">{{ $loop->iteration }}</td>
                    <td class="celda_left">{{ $row_expenses->description }}</td>
                    <td class="celda_left">{{ $row_expenses->method }}</td>
                    <td class="celda_center">{{ $row_expenses->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="celda_right">TOTAL</td>
                <td class="celda_center">S/.{{ number_format($totales_incomes, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tr>
            <td class="headers"><b>RESUMEN INGRESOS - EGRESOS</b></td>
        </tr>
        {{-- @if ($type_box == '1')
                <tr>
                    <td class="headers">TIPO DE MOVIMIENTO <b>INGRESOS</b></td>
                </tr>
            @endif
            @if ($type_box == '2')
                <tr>
                    <td class="headers">TIPO DE MOVIMIENTO <b>EGRESOS</b></td>
                </tr>
            @endif
            @if ($type_box == null)
                <tr>
                    <td class="headers">TIPO DE MOVIMIENTO <b>INGRESOS - EGRESOS</b></td>
                </tr>
            @endif --}}
    </table>
    @if (!empty($data_ingresos) || !empty($depositos) || !empty($data_egresos))

        <div class="">
            <div class=" ">
                @php
                    $totales_ingresos = 0;
                    $totales_egresos = 0;
                    $ingresos = 0;
                    $egresos = 0;
                @endphp
                <table style="border-collapse: collapse;border:1px solid #ddd;width:100%;">
                    <thead>
                        <tr>
                            <th colspan="2">RESUMEN DE VENTA</th>

                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="border-bottom:1px solid #ccc">Apertura Caja <b>S/
                                    {{ number_format($cash->beginning_balance, 2) }}</b></td>
                            <td style="border-bottom:1px solid #ccc">YAPE <b>S/.
                                    {{ number_format(round($yape * 10) / 10, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc">Tarjeta de Credito <b> S/ {{ $tarjetas }}</b>
                            </td>
                            <td style="border-bottom:1px solid #ccc">CULQUI <b>S/.
                                    {{ number_format(round($culqui * 10) / 10, 2) }} </b></td>
                        </tr>

                        <tr>
                            <td style="border-bottom:1px solid #ccc">Efectivo <b>S/.
                                    {{ number_format(round($data_ingresos * 10) / 10, 2) }}</b></td>
                            <td style="border-bottom:1px solid #ccc">PLIN <b>S/.
                                    {{ number_format(round($plin * 10) / 10, 2) }} </b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc">NIUBIZ <b>S/.
                                    {{ number_format(round($niubiz * 10) / 10, 2) }}</b></td>
                            <td style="border-bottom:1px solid #ccc">IZYPAY<b>S/.
                                    {{ number_format(round($izypay * 10) / 10, 2) }} </b></td>
                        </tr>
                        {{-- <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc">Otros Ingresos <b>S/.
                                    {{ number_format(round($data_ingresos_all * 10) / 10, 2) }}</b></td>
                          </tr> --}}
                        {{-- <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc">Gastos <b>S/.
                                    {{ number_format(round($data_egresos * 10) / 10, 2) }}</b></td>

                         </tr> --}}
                        {{-- <tr>
                             <td colspan="2" style="border-bottom:1px solid #ccc">Totales <b>S/.
                                    {{ number_format(round(($transferencias + $depositos + $tarjetas+$data_ingresos_all+$data_ingresos+$yape+$plin)-$data_egresos * 10) / 10, 2) }}</b>
                            </td>
                         </tr> --}}
                        <tr>
                            <td style="border-bottom:1px solid #ccc">Total Venta <b>S/.
                                    <?php
                                    //dd($data_ingresos,$data_ingresos_all,$tarjetas,$transferencias, $depositos,$yape,$plin);
                                    ?>
                                    {{ number_format(round(($data_ingresos + $tarjetas + $transferencias + $depositos + $yape + $plin + $culqui + $izypay + $niubiz) * 10) / 10, 2) }}</b>
                            </td>
                            <td style="border-bottom:1px solid #ccc"></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc"><b>RESUMEN GENERAL</b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>INGRESOS</b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                    {{ number_format(round(($data_ingresos + $data_ingresos_all + $yape + $culqui + $niubiz + $izypay + $tarjetas + $plin + $transferencias + $depositos) * 10) / 10, 2) }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>GASTOS </b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                    {{ number_format(round($data_egresos * 10) / 10, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>TOTAL NETO</b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                    <?php
                                    // dd($data_ingresos,$yape,$plin,$transferencias,$tarjetas,$data_ingresos_all,$depositos,$data_egresos);
                                    ?>
                                    {{ number_format($data_ingresos + $yape + $culqui + $niubiz + $izypay + $plin + $transferencias + $tarjetas + $data_ingresos_all + $depositos - $data_egresos, 2) }}
                                    {{-- {{ number_format(round((($data_ingresos - $data_egresos) +$yape+$plin+ ($transferencias+$tarjetas + $depositos)) * 10) / 10, 2) }} --}}
                                </b>
                            </td>
                        </tr>

                    </tbody>
                </table>
                @php
                    $general_currency = ['200', '100', '50', '20', '10', '5', '2', '1', '0.5', '0.2', '0.1'];
                    $total_counter = 0;
                    
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th colspan="3" class="headers celda_left"><b>CONTEO DE EFECTIVO</b></th>
                        </tr>
                        <tr>
                            <th>Denominacion</th>
                            <th>Unidades</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <body>

                        @foreach ($general_currency as $currency)
                            @if (array_key_exists($currency, $counter))
                                <tr>
                                    @php
                                        $current_total = doubleval($currency) * doubleval($counter[$currency]);
                                        $total_counter += $current_total;
                                    @endphp
                                    <td class="celda_center" style=" border-bottom:1px solid #ccc">{{ $currency }}
                                    </td>
                                    <td class="celda_center" style=" border-bottom:1px solid #ccc">
                                        {{ $counter[$currency] }}</td>

                                    <td class="celda_center" style=" border-bottom:1px solid #ccc">
                                        {{ number_format($current_total, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="2" class="celda_right">TOTAL</td>
                            <td class="celda_center">S/.{{ number_format($total_counter, 2) }}</td>
                        </tr>
                    </body>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" class="header">
                                CUADRE DE EFECTIVO
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="celda_left">
                                BALANCE INICIAL
                            </td>
                            <td class="celda_center">{{ number_format($cash->beginning_balance, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="celda_left">
                                VENTAS EFECTIVO
                            </td>
                            <td class="celda_center"> {{ number_format(round($data_ingresos * 10) / 10, 2) }}</td>
                        </tr>

                        <tr>
                            <td class="celda_left">
                                INGRESOS EFECTIVO
                            </td>
                            <td class="celda_center"> {{ number_format($ingresos_efectivo, 2) }}</td>
                        </tr>
                        <tr>

                            <td class="celda_left">
                                EGRESOS EFECTIVO
                            </td>
                            <td class="celda_center">-{{ number_format($egresos_efectivo, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="celda_left">
                                <b>

                                    TOTAL
                                </b>
                            </td>
                            <td class="celda_center">
                                <b>

                                    {{ number_format(
                                        $ingresos_efectivo - $egresos_efectivo + $cash->beginning_balance + round($data_ingresos * 10) / 10,
                                        2,
                                    ) }}
                                </b>
                            </td>
                        </tr>
                    </tbody>
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
