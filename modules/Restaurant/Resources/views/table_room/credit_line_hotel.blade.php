<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket Garantía</title>
    <style>
        @page {
            margin: 8px;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 80mm;
            /* ancho real del ticket */
            padding: 5px 8px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            border-bottom: 1px dashed #000;
            margin-bottom: 6px;
            padding-bottom: 4px;
        }

        .section {
            margin: 5px 0;
        }

        .section span {
            display: block;
            margin: 2px 0;
            word-wrap: break-word;
            /* evita desbordes si el texto es largo */
        }

        .highlight {
            font-weight: bold;
        }

        .footer {
            border-top: 1px dashed #000;
            margin-top: 10px;
            padding-top: 5px;
            text-align: center;
            font-size: 11px;
        }

        .big-text {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .separator {
            border-bottom: 1px dashed #000;
            margin: 6px 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="header">
            @if ($company->trade_name)
                {{ $company->trade_name }}
            @else
                {{ $company->name }}
            @endif
        </div>

        <div class="section">
            <span class="highlight">HABITACIÓN: {{ $record->room }}</span>
            <span><strong>FECHA:</strong> {{ $record->created_at }}</span>
            <span><strong>HORA:</strong> {{ date('H:i:s') }}</span>
        </div>

        <div class="separator"></div>

        <div class="section">
            <span><strong>HUÉSPED:</strong> {{ $record->customer_name }}</span>
            <span><strong>DOCUMENTO:</strong> {{ $record->customer_number }}</span>
        </div>

        <div class="separator"></div>

        <div class="section big-text">
            SE DEJA UNA GARANTÍA DE: S/ {{ number_format($record->credit_line, 2) }}
        </div>

        <div class="separator"></div>
        <div>
            FIRMANTE: __________________
        </div>

        <div class="footer">
            <strong>CAJERO:</strong> {{ $record->user_name }}
        </div>
    </div>
</body>

</html>
