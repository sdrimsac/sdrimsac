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

                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th style="background-color: silver">#</th>
                            @if ($configuration->sale_note_credit_confirm)
                                <th style="background: silver">Tipo</th>
                            @endif
                            <th style="background: silver">NV-CREDITO</th>
                            <th style="background: silver">Fecha Emisión</th>
                            <th style="background: silver">DNI</th>
                            <th style="background: silver">Cliente</th>
                            <th style="background: silver">Dirección</th>
                            <th style="background: silver">Teléfono</th>
                            <th style="background: silver">ESTADO</th>
                            <th style="background: silver">Cuotas vencidas</th>
                            <th style="background: silver">Fecha de cobro</th>
                            <th style="background: silver">Dias de atraso</th>
                            <th style="background: silver">Monto</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            <tr>
                                <td class="celda">{{ $loop->iteration }}</td>
                                @if ($configuration->sale_note_credit_confirm)
                                    <td class="celda">
                                        @if ($value['is_cash'])
                                            EFECTIVO
                                        @endif
                                        @if ($value['is_product'])
                                            HOGAR
                                        @endif
                                    </td>
                                @endif
                                <td class="celda">
                                    {{ $value['number'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['date_of_issue'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['customer']['number'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['customer']['name'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['customer']['address'] }}
                                </td>
                                <td class="celda">
                                    @php
                                        $telephone = '';
                                        $customer_id = $value['customer_id'];
                                        $telephone = App\Models\Tenant\Person::where('id', $customer_id)->first()
                                            ->telephone;
                                    @endphp
                                    {{ $telephone }}
                                </td>
                                <td class="celda"
                                style="color: {{ $value['state'] == 'PAGADO' ? 'green' : 'red' }};"
                                >
                                    {{ $value['state'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['dues'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['date_of_due'] }}
                                </td>

                                <td class="celda">
                                    {{ $value['differenc_days'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['amount_due'] }}
                                </td>
                            </tr>
                        @endforeach
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
