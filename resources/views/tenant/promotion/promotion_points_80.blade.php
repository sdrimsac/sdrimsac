<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Promocion</title>
    <style>
        @page {
            margin: 3px;
        }
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
            padding: 0;
            margin: 0;
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
            <div class="center">
                <strong style="font-size: 20px;">BUENAS NOTICIAS</strong><br>
                <span style="font-size: 20px;">Estimado cliente, puedes canjear los siguientes productos</span> <strong></strong>
            </div>
            <div class="line"></div>
            <div>
                <strong>CLIENTE:</strong>{{ $customer->name ?? '-' }}<br>
            </div>
            <div class="line"></div>
            @if($promotion_items->isEmpty())
            <div style="text-align:center; color:red; font-size:14px; margin:12px 0;">
                No tienes promociones disponibles para canjear.
            </div>
            @else
            @foreach($promotion_items as $item)
            <div class="voucher-item" style="border:1px solid #222; margin:4px 0; padding:2px; text-align:center;">
                <div style="font-size:12px; font-weight:bold;">{{ $item['promotion_description'] }}</div>
                <div style="font-size:12px;">
                    Puntos acumulados:
                    <span style="font-weight:bold;">{{ $item['customer_points'] }}</span>
                </div>
                <div style="font-size:12px;">Descripción: {{ $item['item_description'] }}</div>
                @php
                // Determinar la ruta de la imagen del producto si existe, de lo contrario usar la imagen por defecto
                $imageFile = $item['item_image'] ?? null;
                $candidatePublicPath = $imageFile ? public_path('storage/uploads/items/' . $imageFile) : null;
                $hasImage = $candidatePublicPath && file_exists($candidatePublicPath);
                $imgSrc = $hasImage
                ? asset('storage/uploads/items/' . $imageFile)
                : asset('logo/imagen-no-disponible.jpg');
                @endphp
                <div style="text-align:center; margin:4px 0;">
                    <br>
                    <img src="{{ $imgSrc }}" alt="{{ $item['item_name'] }}" style="width:25%; height:auto; display:inline-block;">
                    <div style="font-size:12px;">Puntos requeridos: <span style="font-weight:bold;">{{ $item['item_points_value'] }}</span></div>
                    <div style="font-size:12px;">Cantidad: <span style="font-weight:bold;">{{ $item['item_quantity'] }}</span></div>
                    <div style="font-size:12px;">Fecha de vencimiento: <span style="font-weight:bold;">{{ $item['promotion_end_date'] }}</span></div>
                </div>
            </div>
            @endforeach
            @endif
</body>

</html>