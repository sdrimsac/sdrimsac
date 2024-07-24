<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créditos por cobrar</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid black;
        }

        .celda {
            text-align: center;
            padding: 5px;
            border: 0.1px solid black;
        }

        th {
            padding: 5px;
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid black;
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
            background: #409EFF;
            color: white;
            text-align: center;
        }
    </style>
</head>
@php

    $configuration = App\Models\Tenant\Configuration::first();
@endphp

<body>
    <div>
        <p align="center" class="title"><strong>Reporte Créditos por cobrar</strong></p>
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
                <table class="">
                    <thead>
                        <tr>
                            <th>#</th>
                            @if ($configuration->sale_note_credit_confirm)
                                <th>Tipo</th>
                            @endif
                            <th>NV-CREDITO</th>
                            <th class="text-center">Fecha Emisión</th>
                            <th>DNI</th>
                            <th>Cliente</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>ESTADO</th>
                            <th class="text-center">Cuotas vencidas</th>
                            <th class="text-center">Fecha de cobro</th>
                            <th class="text-right">Dias de atraso</th>
                            <th class="text-right">Monto</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $amount_due = 0;
                        @endphp
                        @foreach ($records as $key => $value)
                        @php
                        $amount_due += $value['amount_due'];
                        @endphp
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
                                <td class="celda" style="color: {{ $value['state'] == 'PAGADO' ? 'green' : 'red' }};">
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
                        {{-- <tr>
                            <td class="celda" colspan="9"></td>
                            <td class="celda">Totales PEN</td>
                            <td class="celda">{{ $acum_total_taxed }}</td>
                            <td class="celda">{{ $acum_total_igv }}</td>
                            <td class="celda">{{ $acum_total }}</td>
                        </tr>
                        <tr>
                            <td class="celda" colspan="9"></td>
                            <td class="celda">Totales USD</td>
                            <td class="celda">{{ $acum_total_taxed_usd }}</td>
                            <td class="celda">{{ $acum_total_igv_usd }}</td>
                            <td class="celda">{{ $acum_total_usd }}</td>
                        </tr> --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" style="text-align: right;">
                                <strong>Total:</strong>
                            </td>
                            <td class="celda">
                                {{ $amount_due }}
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
