<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Transacciones Yape</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid #e0e0e0;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .header {
            background-color: #f5f5f5;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .company-info {
            margin-bottom: 20px;
        }

        .cash-info {
            margin-bottom: 20px;
        }

        .summary {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="text-center">
            <h2>REPORTE DE TRANSACCIONES YAPE</h2>
        </div>
    </div>

    <div class="company-info">
        <p><strong>Empresa:</strong> {{ $company_name }}</p>
        <p><strong>RUC:</strong> {{ $company_number }}</p>
        <p><strong>Establecimiento:</strong> {{ $establishment_info['name'] }}</p>
        <p><strong>Dirección:</strong> {{ $establishment_info['address'] }}</p>
        <p><strong>Email:</strong> {{ $establishment_info['email'] }}</p>
        <p><strong>Teléfono:</strong> {{ $establishment_info['phone'] }}</p>
    </div>

    <div class="cash-info">
        <p><strong>Usuario:</strong> {{ $cash_info['user'] }}</p>
        <p><strong>Fecha Apertura:</strong>
            {{ \Carbon\Carbon::parse($cash_info['date_opening'])->format('d/m/Y H:i:s') }}</p>
        @if (isset($cash_info['date_closed']))
            <p><strong>Fecha Cierre:</strong>
                {{ \Carbon\Carbon::parse($cash_info['date_closed'])->format('d/m/Y H:i:s') }}</p>
        @endif
    </div>

    <div class="summary">
        <table>
            <tr>
                <td class="font-bold">Total Transacciones:</td>
                <td class="text-right">{{ $summary['total_transactions'] }}</td>
            </tr>
            <tr>
                <td class="font-bold">Monto Total:</td>
                <td class="text-right">S/ {{ number_format($summary['total_amount'], 2) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>N° Documento</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th class="text-right">Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['date_of_issue'] }}-{{ $transaction['time_of_issue'] }}</td>
                    <td>{{ $transaction['number'] }}</td>
                    <td>{{ $transaction['customer'] }}</td>
                    <td>{{ $transaction['type'] }}</td>
                    
                    <td class="text-right">S/ {{ number_format($transaction['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="font-bold">TOTAL</td>
                <td class="text-right font-bold">S/ {{ number_format($summary['total_amount'], 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; font-size: 9px;" class="text-center">
        Fecha de emisión: {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>
