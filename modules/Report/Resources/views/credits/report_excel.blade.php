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
    <div style="margin-top:20px; margin-bottom:20px;">
        <table>
            <tr>
                <td colspan="15" style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">
                <strong>REPORTE CRÉDITOS POR CLIENTE</strong>
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
    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php

                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">#</th>
                            @if ($configuration->sale_note_credit_confirm)
                                <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Tipo</th>
                            @endif
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">NV-CREDITO</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Fecha Emisión</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">DNI</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Cliente</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Direccion</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Teléfono</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">ESTADO</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Cuotas vencidas</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Fecha de cobro</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Dias de atraso</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Penalidad</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Cuota</th>
                            <th style="background: #afd095; text-align:center;color:#006100;border:1px solid black;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $amount_due = 0;
                        @endphp
                        @foreach ($records as $key => $value)
                        @php
                        $amount_due += $value['total_amount'];
                        @endphp
                            <tr>
                                <td class="celda" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                                @if ($configuration->sale_note_credit_confirm)
                                    <td class="celda" style="border: 1px solid black;">
                                        @if ($value['is_cash'])
                                            EFECTIVO
                                        @endif
                                        @if ($value['is_product'])
                                            HOGAR
                                        @endif
                                    </td>
                                @endif
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['number'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['date_of_issue'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['customer']['number'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['customer']['name'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['customer']['address'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    @php
                                        $telephone = '';
                                        $customer_id = $value['customer_id'];
                                        $telephone = App\Models\Tenant\Person::where('id', $customer_id)->first()
                                            ->telephone;
                                    @endphp
                                    {{ $telephone }}
                                </td>
                                <td class="celda"
                                style="color: {{ $value['state'] == 'PAGADO' ? 'green' : 'red' }}; border: 1px solid black;" 
                                >
                                    {{ $value['state'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['dues'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['date_of_due'] }}
                                </td>

                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['differenc_days'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['penalty_amount'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['amount_due'] }}
                                </td>
                                <td class="celda" style="border: 1px solid black;">
                                    {{ $value['total_amount'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="14" style="text-align: right; background: #afd095; color:#006100;border:1px solid black;">
                                <strong>Total:</strong>
                            </td>
                            <td style="border: 1px solid black; bacground: silver;">
                                <strong>{{ number_format($amount_due, 2) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
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
