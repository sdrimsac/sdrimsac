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
            border:1px solid #ccc;
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
        td{
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
                    style="font-size:13px !important;  font-family: sans-serif !important;border-bottom:1px solid #ccc">Arqueo de Caja {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}
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
                <th class="headers" colspan="4" style="text-align:left !important;">PRODUCTOS VENDIDOS</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Productos</th>
                <th>Cantidad</th>
                <th>Importe</th>
            </tr>
            <tbody>
               <?php
                $total_cantidad= 0;
                $totales_sales= 0;
               ?>
                @foreach ($items['items_by_sales'] as $row)
                    <?php
                    $total_cantidad=$total_cantidad+$row['move_quantity'];
                    $totales_sales=$totales_sales+$row['total'];
                    ?>
                <tr>
                    <td class="celda_center">{{$loop->iteration}}</td>
                    <td>{{$row['description']}}</td>
                    <td  class="celda_center">{{$row['move_quantity']}}</td>
                    <td  class="celda_center">{{$row['total']}}</td>
                </tr>
                @endforeach
                 <tr>
                    <td colspan="2"></td>
                    <td  class="celda_center">{{$total_cantidad}}</td>
                    <td  class="celda_center">{{ number_format($totales_sales,2)}}</td>
                </tr>
            </tbody>
        </table>
        <table width="100%">
            @if ($type_box == '1')
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
            @endif
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
                            <th>RESUMEN DE VENTA EFECTIVO</th>
                            <th>RESUMEN DE MOV. BANCARIO</th>
                         </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-bottom:1px solid #ccc">Apertura Caja <b>S/ {{ number_format($cash->beginning_balance,2) }}</b></td>
                            <td style="border-bottom:1px solid #ccc">YAPE <b>S/.
                                    {{ number_format(round($yape * 10) / 10, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc">Tarjeta de Credito <b> S/  {{$tarjetas}}</b></td>

                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc">Ventas Efectivo <b>S/.
                                    {{ number_format(round($data_ingresos * 10) / 10, 2) }}</b></td>
                            <td style="border-bottom:1px solid #ccc">PLIN <b>S/.
                                    {{ number_format(round($plin * 10) / 10, 2) }} </b></td>
                         </tr>
                         <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc">Otros Ingresos <b>S/.
                                    {{ number_format(round($data_ingresos_all * 10) / 10, 2) }}</b></td>
                          </tr>
                        <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc">Gastos <b>S/.
                                    {{ number_format(round($data_egresos * 10) / 10, 2) }}</b></td>

                         </tr>
                        {{-- <tr>
                             <td colspan="2" style="border-bottom:1px solid #ccc">Totales <b>S/.
                                    {{ number_format(round(($transferencias + $depositos + $tarjetas+$data_ingresos_all+$data_ingresos+$yape+$plin)-$data_egresos * 10) / 10, 2) }}</b>
                            </td>
                         </tr> --}}
                        @if ($data_ingresos > 0)
                            <tr>
                                <td style="border-bottom:1px solid #ccc">Total Venta <b>S/.
                                        {{ number_format(round((($data_ingresos+$data_ingresos_all +$tarjetas+ $transferencias + $depositos+$yape+$plin) - $data_egresos) * 10) / 10, 2) }}</b>
                                </td>
                                <td style="border-bottom:1px solid #ccc"></td>
                             </tr>
                        @endif

                        <tr>
                            <td colspan="2" style="border-bottom:1px solid #ccc"><b>RESUMEN GENRAL</b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>INGRESOS</b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                    {{ number_format(round(($data_ingresos + $data_ingresos_all + $yape + $tarjetas + $plin + $transferencias + $depositos) * 10) / 10, 2) }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>GASTOS </b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                    {{ number_format(round(($data_egresos) * 10) / 10, 2) }}</b></td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #ccc"><b>TOTAL</b></td>
                            <td style="border-bottom:1px solid #ccc"><b>S/.
                                        <?php
                                           // dd($data_ingresos,$yape,$plin,$transferencias,$tarjetas,$data_ingresos_all,$depositos,$data_egresos);

                                        ?>
                                        {{ number_format(($data_ingresos+$yape+$plin+$transferencias+$tarjetas+$data_ingresos_all+$depositos) - $data_egresos,2)}}
                                    {{-- {{ number_format(round((($data_ingresos - $data_egresos) +$yape+$plin+ ($transferencias+$tarjetas + $depositos)) * 10) / 10, 2) }} --}}
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
