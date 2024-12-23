<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Promociones</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .celda, th, td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .title {
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header-info {
            margin-bottom: 20px;
        }

        .header-info p {
            margin: 0;
        }

        .details-row {
            background-color: #f9f9f9;
        }

        .details-header {
            font-weight: bold;
            background-color: #e0e0e0;
        }

        .details-table {
            margin: 0;
            padding: 0;
        }

        .details-table th, .details-table td {
            padding: 4px;
        }
    </style>
</head>
@php
    $configuration = App\Models\Tenant\Configuration::first();
@endphp
<body>
    <div>
        <p class="title">Reporte Promociones</p>
    </div>
    <div class="header-info">
        <table>
            <tr>
                <td><p><strong>Empresa:</strong> {{ $company->name }}</p></td>
                <td><p><strong>Fecha:</strong> {{ date('Y-m-d') }}</p></td>
            </tr>
            <tr>
                <td><p><strong>Ruc:</strong> {{ $company->number }}</p></td>
            </tr>
        </table>
    </div>
    @if (!empty($records))
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Promoción</th>
                    <th>{{ $configuration->promotions_by_points ? 'Puntos' : 'Monto' }}</th>
                    <th>Canjes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->customer_name }}</td>
                        <td>{{ $record->promotion_name }}</td>
                        <td>{{ $configuration->promotions_by_points ? $record->points : $record->acc_total }}</td>
                        <td>{{ $record->change_count }}</td>
                    </tr>
                    @if ($record->receiveds->isNotEmpty())
                        <tr class="details-header">
                            <td colspan="5">Detalles:</td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="5">
                                <table class="details-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Vendedor</th>
                                            <th>Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($record->receiveds as $received)
                                            <tr>
                                                <td>{{ $received['product'] }}</td>
                                                <td>{{ $received['quantity'] }}</td>
                                                <td>{{ $received['date'] }}</td>
                                                <td>{{ $received['time'] }}</td>
                                                <td>{{ $received['seller'] }}</td>
                                                <td>{{ $received['points'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
