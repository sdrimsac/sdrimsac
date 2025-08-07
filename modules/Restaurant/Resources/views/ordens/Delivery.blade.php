<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket Delivery</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            color: #000;
            font-weight: bold;
        }

        .ticket {
            width: 226.77px;
            /* 80mm */
            padding: 4px 2px 4px 0px;
            margin-left: -18px;
            margin-top: -20px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-weight: bold;
        }

        th,
        td {
            padding: 2px 0;
        }

        th {
            border-bottom: 1px dashed #000;
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .thanks {
            margin-top: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="center" style="margin-bottom: 6px;">

            <div class="text-center company_logo_box pt-5 pl-5">

                {{-- @if ($company->document_logo)
                    <img src="data:{{ mime_content_type(public_path('storage/uploads/logos/' . $company->document_logo)) }};base64,{{ base64_encode(file_get_contents(public_path('storage/uploads/logos/' . $company->document_logo))) }}"
                        alt="{{ $company->trade_name }}"
                        style="max-width: 160px; max-height: 140px; object-fit: contain;">
                @else
                    <img src="data:{{ mime_content_type(public_path('storage/uploads/logos/' . $company->logo)) }};base64,{{ base64_encode(file_get_contents(public_path('storage/uploads/logos/' . $company->logo))) }}"
                        alt="{{ $company->trade_name }}"
                        style="max-width: 160px; max-height: 140px; object-fit: contain;">
                @endif --}}

                @if ($establishment->logo || $establishment->document_logo)

                    @if ($establishment->document_logo)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$establishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$establishment->document_logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
                            contain"
                            style="width: 160px; height: 140px; max-width: 160px; max-height: 140px; object-fit: contain;">
                    @else
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$establishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$establishment->logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
                            contain"
                            style="width: 160px; height: 140px; max-width: 160px; max-height: 140px; object-fit: contain;">
                    @endif
                @else
                    @if ($company->logo)
                        @if ($company->document_logo)
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="
                                contain"
                                style="width: 160px; height: 140px; max-width: 160px; max-height: 140px; object-fit: contain;">
                        @else
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="
                                contain"
                                style="width: 160px; height: 140px; max-width: 160px; max-height: 140px; object-fit: contain;">
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <div class="center bold">
            {{ $company->trade_name }}<br>
            {{ $company->name }}<br>
            RUC: {{ $company->number }}<br>
            {{ $establishment->address }}<br>
            Tel: {{ $establishment->telephone }}<br>
        </div>

        <div class="line"></div>

        <div class="center">
            <strong style="font-size: 20px;">DELIVERY</strong><br>
            <span style="font-size: 20px;">Pedido Nº</span> <strong
                style="font-size: 20px;">{{ $orden->correlative }}</strong>
        </div>
        <div class="line"></div>
        <div>
            <strong>CLIENTE:</strong> {{ $delivery->person->name }}<br>
            <strong>DIRECCIÓN ENTREGA:</strong> {{ $delivery->address }}<br>
            <strong>REFERENCIA:</strong> {{ $delivery->reference }}<br>
            <strong>CELULAR:</strong> {{ $delivery->telephone }}<br>


            <strong>FECHA EMISIÓN:</strong> {{ $orden->created_at->format('Y-m-d') }}
        </div>
        <div class="line"></div>
        <table>
            <thead>
                <tr>
                    <th>CANT.</th>
                    <th>DESCRIPCIÓN</th>
                    <th class="right">P/U</th>
                    <th class="right">TOTAL</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orden_items as $item)
                    <tr>
                        <td>{{ intval($item['quantity']) }}</td>
                        <td>{{ strtoupper($item['description']) }}</td>
                        <td class="right">{{ number_format($item['price'], 2) }}</td>
                        <td class="right">{{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="line"></div>

        <table>
            <tr>
                <td colspan="3">Sub Total S/</td>
                @php
                    $subtotal = collect($orden_items)->sum(function ($item) {
                        return $item['quantity'] * $item['price'];
                    });
                @endphp
                <td class="right">{{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">Envío S/</td>
                <td class="right">{{ number_format($orden->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="bold">TOTAL S/</td>
                @php
                    $total = $subtotal + $orden->shipping_cost;
                @endphp
                <td class="right bold">{{ number_format($total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="center thanks">¡Gracias por su compra!</td>
            </tr>
            <tr>
                <td colspan="4" class="center">Software desarrollado por {{ config('app.name') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
