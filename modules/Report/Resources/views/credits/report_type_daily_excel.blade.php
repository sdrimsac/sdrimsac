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
                <strong>REPORTE DIARIO DE CRÉDITOS</strong>

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
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">TIPO CREDITO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">USUARIO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">TIPO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">CLIENTE</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">DNI</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">DIAS DE ATRASO</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-center">COBRO POR HORA</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-end">COBRO POR CUOTA</th>
                            <th  style="background: #afd095; text-align:center;color:#006100;border:1px solid black;"  class="text-end">TOTAL A COBRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $record)
                            @php

                                $acum_total += $record['amount_due'];
                                
                            @endphp
                            <tr>
                                <td style="border:1px solid black;" >{{ $loop->iteration }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['is_cash'] ? 'EFECTIVO':'HOGAR' }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['user_name'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['type_payment'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['customer']["name"] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['customer']["number"] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['differenc_days'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['penalty'] }}</td>
                                <td style="border:1px solid black;"  class="text-center">{{ $record['quote_payment'] }}</td>
                                <td style="border:1px solid black;"  class="text-end">{{ $record['amount_due'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border:1px solid black;" colspan="2"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-center"></td>
                            <td style="border:1px solid black;" class="text-end">TOTALES</td>
                            <td style="border:1px solid black;" class="text-end">{{ $acum_total }}</td>
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
