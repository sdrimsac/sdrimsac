<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de transferencias</title>
    
</head>

<body>
    <div>
        <p align="center" class="title"><strong>Reporte de transferencias</strong></p>
    </div>
    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td>
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
                <td>
                    <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong>{{ $company->number }}</p>
                </td>

            </tr>
        </table>
    </div>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php

                @endphp
                <table style="
                width: 100%;
                border-spacing: 0;
                border: 1px solid black;
                border-collapse: collapse
                ">
                    <thead>
                        <tr>
                            <th style="border:1px solid black; background:gray; " >#</th>
                            <th style="border:1px solid black; background:gray; "  class="text-center">Fecha</th>
                            <th style="border:1px solid black; background:gray; "  class="text-center">Responsable</th>
                            <th style="border:1px solid black; background:gray; "  class="text-center">Tipo de transacción</th>
                            <th style="border:1px solid black; background:gray; "  class="text-center">Ingreso </th>
                            <th style="border:1px solid black; background:gray; "  class="text-left">Egreso</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_income = 0;
                            $total_expense = 0;
                        @endphp
                        @foreach ($records as $key => $value)
                            <tr>
                                <td style="border:1px solid black; ">{{ $key + 1 }}</td>
                                <td style="border:1px solid black; " class="celda">{{ $value['date_of_issue'] }}</td>
                                <td style="border:1px solid black; " class="celda">{{ $value['user_name'] }}</td>
                                <td style="border:1px solid black; " class="celda">{{ $value['type'] }}</td>
                                <td style="border:1px solid black;color:green;" class="celda">{{ $value['income'] }}</td>
                                <td style="border:1px solid black;color:red; " class="celda">{{ $value['expense'] }}</td>

                                @php
                                    $total_income += $value['income'];
                                    $total_expense += $value['expense'];
                                @endphp
                            </tr>
                        @endforeach
                        <tr>
                            <td style="border:1px solid black;" colspan="3" class="celda"></td>
                            <td style="border:1px solid black;"  class="celda">Total</td>
                            <td style="border:1px solid black;color:green;" class="celda">{{ $total_income }}</td>
                            <td style="border:1px solid black;color:red;" class="celda">{{ $total_expense }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
