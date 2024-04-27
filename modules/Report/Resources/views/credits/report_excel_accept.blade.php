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
                            <th>Nota de Venta</th>
                            <th class="text-center">Fecha Emisión</th>
                            <th>DNI</th>
                            <th>Cliente</th>
                            <th>Monto otorgado</th>
                            <th>%</th>
                            <th>Nr_dias</th>
                            <th>Periodo</th>
                            <th>Mes</th>
                            <th>Penalidad</th>
                            <th>Monto cobrado</th>
                            <th>Ganacia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            <tr>
                                <td class="celda">{{ $loop->iteration }}</td>
                                @if ($configuration->sale_note_credit_confirm)
                                    <td class="celda">
                                        @if ($value['is_cash'])
                                            Efectivo
                                        @endif
                                        @if ($value['is_product'])
                                            Hogar
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
                                    {{ $value['total'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['tasa'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['r_dias'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['type_payment'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['month'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['penalties'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['total_paid'] }}
                                </td>
                                <td class="celda">
                                    {{ $value['difference_payment'] }}
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
