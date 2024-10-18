<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        CREDITO {{ $credit_info->series }} - {{ $credit_info->number }}
    </title>

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
    <table style="width: 100%">
        <tr>
            <td width="50%" style="padding-right: 15px;">
                <table border="1" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Recibo</th>
                            <th>Fecha de pago</th>
                            <th>Monto</th>
                            <th>Penalidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($receipts) > 0)
                            @foreach ($receipts as $receipt)
                                <tr>
                                    <td>{{ $receipt->number }}</td>
                                    <td>{{ $receipt->date_of_issue }}</td>
                                    <td>{{ $receipt->amount }}</td>
                                    <td>{{ $receipt->penalty_paid }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No se encontraron cuotas.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </td>
            <td width="50%">
                <table border="1" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Código interno</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($items) > 0)
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->internal_id }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">No se encontraron productos.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
