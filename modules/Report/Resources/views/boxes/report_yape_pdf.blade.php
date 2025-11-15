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

        .info-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .company-info {
            width: 60%;
            float: left;
            margin-bottom: 20px;
        }

        .cash-info {
            width: 35%;
            float: right;
            border: 2px solid #ff0000;
            padding: 10px;
            margin-bottom: 20px;
        }

        .clearfix {
            clear: both;
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
            <h2>REPORTE DE TRANSACCIONES YAPE & PLIN</h2>
        </div>
    </div>

    <div class="info-container">
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
        <div class="clearfix"></div>
    </div>
    
    <!-- Resumen General -->
    <div class="summary">
        <h3 class="text-center">RESUMEN GENERAL</h3>
        <table>
            <tr>
                <td class="font-bold">Total Transacciones YAPE:</td>
                <td class="text-right">{{ $yape_data['total_transactions'] }}</td>
                <td class="text-right">S/ {{ $yape_data['total_amount'] }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total Transacciones PLIN:</td>
                <td class="text-right">{{ $plin_data['total_transactions'] }}</td>
                <td class="text-right">S/ {{ $plin_data['total_amount'] }}</td>
            </tr>
            <tr style="background-color: #e0e0e0;">
                <td class="font-bold">TOTAL GENERAL:</td>
                <td class="text-right font-bold">{{ $summary['total_transactions'] }}</td>
                <td class="text-right font-bold">S/ {{ $summary['total_amount'] }}</td>
            </tr>
        </table>
    </div>

    <!-- Sección YAPE -->
    @if(count($yape_data['transactions']) > 0)
    <div style="margin-bottom: 30px;">
        <h3 style="background-color: #4CAF50; color: white; padding: 10px; margin: 20px 0 10px 0; text-align: center;">
            TRANSACCIONES YAPE ({{ $yape_data['total_transactions'] }})
        </h3>
        
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
                @foreach ($yape_data['transactions'] as $transaction)
                    <tr>
                        <td>{{ $transaction['date_of_issue'] }}-{{ $transaction['time_of_issue'] }}</td>
                        <td>{{ $transaction['number'] }}</td>
                        <td>{{ $transaction['customer'] }}</td>
                        <td>{{ $transaction['type'] }}</td>
                        <td class="text-right">S/ {{ $transaction['amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f0f8f0;">
                    <td colspan="4" class="font-bold">SUBTOTAL YAPE</td>
                    <td class="text-right font-bold">S/ {{ $yape_data['total_amount'] }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <div style="margin-bottom: 30px;">
        <h3 style="background-color: #4CAF50; color: white; padding: 10px; margin: 20px 0 10px 0; text-align: center;">
            TRANSACCIONES YAPE (0)
        </h3>
        <p style="text-align: center; padding: 20px; background-color: #f5f5f5;">No hay transacciones YAPE registradas</p>
    </div>
    @endif

    <!-- Sección PLIN -->
    @if(count($plin_data['transactions']) > 0)
    <div style="margin-bottom: 30px;">
        <h3 style="background-color: #2196F3; color: white; padding: 10px; margin: 20px 0 10px 0; text-align: center;">
            TRANSACCIONES PLIN ({{ $plin_data['total_transactions'] }})
        </h3>
        
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
                @foreach ($plin_data['transactions'] as $transaction)
                    <tr>
                        <td>{{ $transaction['date_of_issue'] }}-{{ $transaction['time_of_issue'] }}</td>
                        <td>{{ $transaction['number'] }}</td>
                        <td>{{ $transaction['customer'] }}</td>
                        <td>{{ $transaction['type'] }}</td>
                        <td class="text-right">S/ {{ $transaction['amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #e3f2fd;">
                    <td colspan="4" class="font-bold">SUBTOTAL PLIN</td>
                    <td class="text-right font-bold">S/ {{ $plin_data['total_amount'] }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <div style="margin-bottom: 30px;">
        <h3 style="background-color: #2196F3; color: white; padding: 10px; margin: 20px 0 10px 0; text-align: center;">
            TRANSACCIONES PLIN (0)
        </h3>
        <p style="text-align: center; padding: 20px; background-color: #f5f5f5;">No hay transacciones PLIN registradas</p>
    </div>
    @endif

    <div style="margin-top: 20px; font-size: 9px;" class="text-center">
        Fecha de emisión: {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>
