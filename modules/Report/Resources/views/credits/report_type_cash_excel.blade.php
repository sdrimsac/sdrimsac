<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créditos por cobrar</title>

</head>
@php

    $configuration = App\Models\Tenant\Configuration::first();

@endphp

<body>
    <table>
        <tr>
            <td colspan="13" style="text-align: center;">
                <strong>REPORTE CRÉDITOS POR CLIENTE</strong>

            </td>
        </tr>
    </table>

    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td colspan="6">
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
                <td colspan="7">
                    <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="13">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>

            </tr>
        </table>
    </div>
    @if (!empty($records))

        <div class="">
            <div class=" ">
                @php
                    $acum_total = 0;
                    $acum_total_penalties = 0;
                    $acum_total_gain = 0;
                    $acum_gain = 0;
                @endphp
                <table style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;" >#</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">CANT.</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">CREDI EFECTIVO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">%</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">TIPO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">GANANCIA %</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-end">MORA</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-end">UTILIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $record)
                            @php

                                $acum_total += $record['total'];
                                $acum_total_penalties += $record['total_penalties'];
                                $acum_total_gain += $record['total_gain'];
                                $acum_gain += $record['gain'];
                            @endphp
                            <tr>
                                <td style="border:1px solid black;" >{{ $loop->iteration }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['count'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['total'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['tasa'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['type_payment'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['gain'] }}</td>
                                <td style="border:1px solid black;"  class="text-end">{{ $record['total_penalties'] }}</td>
                                <td style="border:1px solid black;"  class="text-end">{{ $record['total_gain'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border:1px solid black;" colspan="2">TOTALES</td>
                            <td style="border:1px solid black;" class="text-center">{{ $acum_total }}</td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center">{{ $acum_gain }}</td>
                            <td style="border:1px solid black;" class="text-end">{{ $acum_total_penalties }}</td>
                            <td style="border:1px solid black;" class="text-end">{{ $acum_total_gain }}</td>
                        </tr>
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
