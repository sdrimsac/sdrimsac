<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Personal - {{ $company->name ?? 'Sin nombre' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 8px;
        }
        
        @page {
            size: A3 landscape;
            margin: 15mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }
        
        .company-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .company-info div {
            flex: 1;
        }
        
        .dates-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }
        
        .dates-info div {
            flex: 1;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .data-table th {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            line-height: 1.3;
            vertical-align: middle;
        }
        
        .data-table td {
            border: 1px solid #ccc;
            padding: 5px 4px;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
            line-height: 1.3;
        }
        
        .data-table .text-left {
            text-align: left;
        }
        
        .data-table .text-center {
            text-align: center;
        }
        
        .data-table .text-right {
            text-align: right;
        }
        
        .personal-column {
            width: 14%;
            text-align: left;
        }
        
        .date-column {
            width: 10%;
        }
        
        .day-column {
            width: 7%;
        }
        
        .hours-detail-column {
            width: 16%;
            text-align: left;
            font-size: 10px;
        }
        
        .hours-total-column {
            width: 7%;
        }
        
        .factor-column {
            width: 8%;
        }
        
        .extras-column {
            width: 7%;
        }
        
        .number-column {
            width: 4%;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        
        .summary-table th {
            background-color: #e6f3ff;
            border: 1px solid #999;
            padding: 7px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        
        .summary-table td {
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
            font-size: 12px;
        }
        
        .summary-table .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        
        .summary-table .cobrar-row {
            background-color: #e6ffe6;
            font-weight: bold;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        /* Estilos adicionales para mejor legibilidad */
        .data-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .data-table tbody tr:hover {
            background-color: #f0f8ff;
        }
        
        small {
            font-size: 0.85em;
            color: #666;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        /* Optimización para A3 landscape */
        @media print {
            @page {
                size: A3 landscape;
                margin: 10mm;
            }
            
            body {
                font-size: 12px;
            }
            
            .data-table {
                font-size: 11px;
                table-layout: fixed;
            }
            
            .data-table th,
            .data-table td {
                font-size: 11px;
                padding: 5px 4px;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }
            
            .hours-detail-column {
                font-size: 10px;
            }
            
            .summary-table {
                font-size: 12px;
            }
            
            .summary-table th,
            .summary-table td {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Personal con Totales</h1>
        
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px;">
            <div style="flex:1; min-width:0;">
                <div>
                    <strong>Empresa:</strong> {{ $company->name ?? 'Sin nombre' }}
                </div>
                <div>
                    <strong>RUC:</strong> {{ $company->number ?? 'Sin RUC' }}
                </div>
            </div>

            <div style="flex:1; min-width:0; text-align:right;">
                {{-- <div>
                    <strong>Período:</strong> {{ $date_start }} hasta {{ $date_end }}
                </div> --}}
                <div>
                    <strong>Fecha de generación:</strong> {{ $generation_date }}
                </div>
            </div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="number-column">#</th>
                <th class="personal-column">Personal<br><small>Cargo</small></th>
                <th class="date-column">Fecha<br>Ingreso y Salida</th>
                <th class="day-column">Día</th>
                <th class="hours-detail-column">Horas Trabajadas<br><small>(Detalle)</small></th>
                <th class="hours-total-column">H.<br>Total</th>
                <th class="factor-column">Pago/<br>Día</th>
                <th class="extras-column">Extra<br>25%</th>
                <th class="extras-column">Extra<br>35%</th>
                <th class="extras-column">Faltante</th>
                <th class="factor-column">Adelantos</th>
                <th class="factor-column">Consumos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td class="text-center"><strong>{{ $record['numero'] }}</strong></td>
                <td class="text-left">
                    <strong>{{ $record['persona_nombre'] }}</strong><br>
                    <small style="color: #666;">{{ $record['persona_cargo'] }}</small>
                </td>
                <td class="text-center">
                    {{ $record['fecha_ingreso'] }}<br>
                    <small>a</small><br>
                    {{ $record['fecha_salida'] }}
                </td>
                <td class="text-center"><strong>{{ $record['dia_semana'] }}</strong></td>
                <td class="text-left" style="font-size: 10px; line-height: 1.4;">{!! $record['horas_trabajadas_detalle'] !!}</td>
                <td class="text-center"><strong>{{ $record['horas_trabajadas'] }}</strong></td>
                <td class="text-right">{{ number_format($record['factor_diario'], 2) }}</td>
                <td class="text-center">{{ $record['horas_extras_25'] }}</td>
                <td class="text-center">{{ $record['horas_extras_35'] }}</td>
                <td class="text-center">{{ $record['horas_faltante'] }}</td>
                <td class="text-right">{{ number_format($record['adelantos'], 2) }}</td>
                <td class="text-right">{{ number_format($record['consumos'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($totales))
    
    <h2 style="text-align: center; margin: 30px 0 20px 0; font-size: 18px; color: #333;">TOTALES POR PERSONA</h2>
    
    <table class="summary-table">
        <thead>
            <tr>
                <th style="width: 22%;">Personal</th>
                <th style="width: 8%;">Días</th>
                <th style="width: 10%;">H. Trabajadas</th>
                <th style="width: 10%;">Factor Diario</th>
                <th style="width: 8%;">Extra 25%</th>
                <th style="width: 8%;">Extra 35%</th>
                <th style="width: 8%;">Faltante</th>
                <th style="width: 10%;">Adelantos</th>
                <th style="width: 10%;">Consumos</th>
                <th style="width: 12%;">A COBRAR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($totales as $nombrePersona => $total)
            <tr class="total-row">
                <td class="text-left"><strong>{{ $nombrePersona }}</strong></td>
                <td class="text-center">{{ $total['dias'] }}</td>
                <td class="text-center">{{ $total['horasTrabajadas_formatted'] }}</td>
                <td class="text-right">{{ number_format($total['factorDiario'], 2) }}</td>
                <td class="text-center">{{ $total['horasExtras25_formatted'] }}</td>
                <td class="text-center">{{ $total['horasExtras35_formatted'] }}</td>
                <td class="text-center">{{ $total['horasFaltante_formatted'] }}</td>
                <td class="text-right">{{ number_format($total['adelantos'], 2) }}</td>
                <td class="text-right">{{ number_format($total['consumos'], 2) }}</td>
                <td class="text-right cobrar-row"><strong>{{ number_format($total['aCobrar'], 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>