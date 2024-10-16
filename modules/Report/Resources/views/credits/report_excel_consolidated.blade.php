<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONSOLIDADO</title>

</head>
@php

    $configuration = App\Models\Tenant\Configuration::first();

@endphp

<body>
    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td colspan="15" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <strong>REPORTE CONSOLIDADO</strong>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="background: #afd095; color:#006100;border:1px solid black;">
                    <p><strong>Empresa: </strong>{{ $company->name }}</p>
                </td>
                <td colspan="4" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
                <td colspan="3" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                    <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
        </table>
    </div>
    @if ($data !== null)
        <br><br>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <thead style="background: #afd095; color: #006100; text-align: center; border: 1px solid black;">
                <tr>
                    <th colspan="2" style="padding: 8px; border: 1px solid black;">TOTAL A COBRAR</th>
                    <th colspan="2" style="padding: 8px; border: 1px solid black;">UTILIDAD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 8px; border: 1px solid black;"></td>
                    <td style="padding: 8px; border: 1px solid black;">
                        S/ {{ number_format($data['sum_total_general'], 2) }}
                    </td>
                    <td colspan="2" style="padding: 8px; border: 1px solid black;">
                        S/ {{ number_format($data['gain'], 2) }}
                    </td>
                </tr>
                @foreach ($data['data'] as $key => $value)
                    <tr>
                        <td style="padding: 8px; border: 1px solid black;">{{ $key }}</td>
                        <td style="padding: 8px; border: 1px solid black;">S/ {{ number_format($value, 2) }}</td>
                        <td style="padding: 8px; border: 1px solid black;"></td>
                        <td style="padding: 8px; border: 1px solid black;"></td>
                    </tr>
                @endforeach
                <tr>
                    <td style="padding: 8px; border: 1px solid black;">GASTOS</td>
                    <td style="padding: 8px; border: 1px solid black;">
                        S/ {{ number_format($data['expenses'], 2) }}
                    </td>
                    <td style="padding: 8px; border: 1px solid black;">COMPRAS DE PRODUCTOS</td>
                    <td style="padding: 8px; border: 1px solid black;">
                        S/ {{ number_format($data['purchases'], 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
