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
            padding: 0.1cm;
            margin: 0;
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
            border: 0.1px solid #000000;
        }

        .celda_center {
            text-align: center;
            padding: 5px;
            border: 0.1px solid #000000;
        }

        .celda_right {
            text-align: right;
            padding: 5px;
            border: 0.1px solid #000000;
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
            /* padding: 3px; */
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
            /* margin: 0.5cm 0.5cm 0cm 0.5cm; */
            padding: 0.1cm;
            margin: 0.1cm;
            font-family: sans-serif;
        }

        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }


        h3 {
            padding: 1px;
            margin: 1px;
        }

        body {
            padding: 0.1cm;
            margin: 0.1cm;
            /* margin: 1.5cm 0.5cm 0.5cm 0.5cm; */
        }
    </style>
</head>

<body>
    <table>
        <div>
            <table>
                <tr>
                    <td class="text-end" colspan="11" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 15px; font-weight: bold;">
                        <h3>Reporte Global Salud</h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-end" colspan="11" style="border: 2px solid black; background-color: #DCDCDC; font-size: 13px;">
                        <p><strong>Empresa: </strong>{{ $company->name }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="text-end" colspan="6" style="border: 2px solid black; background-color: #DCDCDC; font-size: 13px;">
                        <p><strong>Ruc: </strong>{{ $company->number }}</p>
                    </td>
                    <td class="text-end" colspan="5" style="border: 2px solid black; background-color: #DCDCDC; font-size: 13px;">
                        <p><strong>Fecha: </strong>{{ $month }}</p>
                    </td>
                </tr>
            </table>
        </div>
        @if (!empty($records))
        <div class="">
            <div class=" ">
                @php
                $year = $month;

               
                $records_service = array_filter($records, function ($record) {
                return $record['is_service'] == 1;
                });
                $records_medicine = array_filter($records, function ($record) {
                return $record['is_service'] == 0;
                });
                $total_service = array_reduce(
                $records_service,
                function ($carry, $record) {
                return $carry + $record['ft_total'] + $record['bv_total'];
                },
                0,
                );
                $total_medicine = array_reduce(
                $records_medicine,
                function ($carry, $record) {
                return $carry + $record['ft_total'] + $record['bv_total'];
                },
                0,
                );
                @endphp
                <table>
                    <thead>
                        <tr>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Rubro</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Año</th>
                            
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Establecimiento</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Serie</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Nro_ini</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Nro_fin</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Anulados</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Rechazados</th>
                            <th class="celda" style="border: 2px solid black; background-color: #DCDCDC;">Notas de crédito</th>
                            <th class="celda_right" style="border: 2px solid black; background-color: #DCDCDC;">Importe total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records_service as $key => $record)
                        @if ($record['has_ft_info'])
                        @php
                        $serie_ft = isset($record['first_ft']->series) ? $record['first_ft']->series : '';
                        $nro_ini_ft = isset($record['first_ft']->number) ? $record['first_ft']->number : '';
                        $nro_fin_ft = isset($record['last_ft']->number) ? $record['last_ft']->number : '';
                        $anulates_voided_ft =
                        count($record['anulates_voided_ft']) > 0
                        ? join(',', $record['anulates_voided_ft'])
                        : '';
                        $rejected_ft =
                        count($record['rejected_ft']) > 0 ? join(',', $record['rejected_ft']) : '';

                        $notes_ft = count($record['notes_ft']) > 0 ? join(',', $record['notes_ft']) : '';
                        @endphp
                        <tr>
                            <td class="celda">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                           
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $serie_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_ini_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_fin_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $anulates_voided_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $rejected_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $notes_ft }}</td>
                            <td class=" celda_right" style="border: 2px solid black;">{{ $record['ft_total'] }}</td>
                        </tr>
                        @endif
                        @if ($record['has_bv_info'])
                        @php
                        $serie_bv = isset($record['first_bv']->series) ? $record['first_bv']->series : '';
                        $nro_ini_bv = isset($record['first_bv']->number) ? $record['first_bv']->number : '';
                        $nro_fin_bv = isset($record['last_bv']->number) ? $record['last_bv']->number : '';
                        $anulates_voided_bv =
                        count($record['anulates_voided_bv']) > 0
                        ? join(',', $record['anulates_voided_bv'])
                        : '';
                        $rejected_bv =
                        count($record['rejected_bv']) > 0 ? join(',', $record['rejected_bv']) : '';
                        $notes_bv = count($record['notes_bv']) > 0 ? join(',', $record['notes_bv']) : '';
                        @endphp
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                           
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $serie_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_ini_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_fin_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $anulates_voided_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $rejected_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $notes_bv }}</td>
                            <td class=" celda_right" style="border: 2px solid black;">{{ $record['bv_total'] }}</td>

                        </tr>
                        @endif
                        @if (!$record['has_ft_info'] && !$record['has_bv_info'])
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                            
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class=" celda_right" style="border: 2px solid black;">0</td>
                        </tr>
                        @endif
                        @endforeach
                        @if (count($records_service) > 0)
                        <tr>
                            <td class="celda" colspan="9">
                                <strong>
                                    Total Servicios
                                </strong>

                            </td>
                            <td class="celda_right" style="border: 2px solid black;">
                                <strong>
                                    {{ $total_service }}
                                </strong>
                            </td>
                        </tr>
                        @endif
                        @foreach ($records_medicine as $key => $record)
                        @if ($record['has_ft_info'])
                        @php
                        $serie_ft = isset($record['first_ft']->series) ? $record['first_ft']->series : '';
                        $nro_ini_ft = isset($record['first_ft']->number) ? $record['first_ft']->number : '';
                        $nro_fin_ft = isset($record['last_ft']->number) ? $record['last_ft']->number : '';
                        $anulates_voided_ft =
                        count($record['anulates_voided_ft']) > 0
                        ? join(',', $record['anulates_voided_ft'])
                        : '';
                        $rejected_ft =
                        count($record['rejected_ft']) > 0 ? join(',', $record['rejected_ft']) : '';
                        $notes_ft = count($record['notes_ft']) > 0 ? join(',', $record['notes_ft']) : '';
                        @endphp
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                        
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $serie_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_ini_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_fin_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $anulates_voided_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $rejected_ft }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $notes_ft }}</td>
                            <td class=" celda_right" style="border: 2px solid black;">{{ $record['ft_total'] }}</td>
                        </tr>
                        @endif
                        @if ($record['has_bv_info'])
                        @php
                        $serie_bv = isset($record['first_bv']->series) ? $record['first_bv']->series : '';
                        $nro_ini_bv = isset($record['first_bv']->number) ? $record['first_bv']->number : '';
                        $nro_fin_bv = isset($record['last_bv']->number) ? $record['last_bv']->number : '';
                        $anulates_voided_bv =
                        count($record['anulates_voided_bv']) > 0
                        ? join(',', $record['anulates_voided_bv'])
                        : '';
                        $rejected_bv =
                        count($record['rejected_bv']) > 0 ? join(',', $record['rejected_bv']) : '';
                        $notes_bv = count($record['notes_bv']) > 0 ? join(',', $record['notes_bv']) : '';
                        @endphp
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                          
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $serie_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_ini_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $nro_fin_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $anulates_voided_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $rejected_bv }}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $notes_bv }}</td>
                            <td class=" celda_right" style="border: 2px solid black;">{{ $record['bv_total'] }}</td>

                        </tr>
                        @endif
                        @if (!$record['has_ft_info'] && !$record['has_bv_info'])
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{ $record['is_service'] == 1 ? 'Servicios' : 'Medicamentos' }}
                            </td>
                            <td class="celda" style="border: 2px solid black;">{{ $year }}</td>
                           
                            <td class="celda" style="border: 2px solid black;">{{ $record['establishment'] }}</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;">-</td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class="celda" style="border: 2px solid black;"></td>
                            <td class=" celda_right" style="border: 2px solid black;">0</td>
                        </tr>
                        @endif
                        @endforeach
                        @if (count($records_medicine) > 0)
                        <tr>
                            <td class="celda" colspan="9" style="border: 2px solid black; background-color: #DCDCDC;">
                                <strong>
                                    Total Medicamentos
                                </strong>
                            </td>
                            <td class="celda_right" style="border: 2px solid black;">
                                <strong>
                                    {{ $total_medicine }}
                                </strong>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="celda" colspan="9" style="border: 2px solid black; background-color: #DCDCDC;">
                                <strong>
                                    Total General
                                </strong>

                            </td>
                            <td class="celda_right" style="border: 2px solid black;">
                                <strong>
                                    {{ $total_service + $total_medicine }}
                                </strong>
                            </td>
                        </tr>
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