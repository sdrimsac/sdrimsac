
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promociones disponible</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { margin: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }
        .summary {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #888;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    @php
        // Normaliza variables cuando vienen del controlador
        $cliente = isset($document_customer) && is_object($document_customer) ? $document_customer : null;
        $productos = isset($receiveds) ? (is_iterable($receiveds) ? $receiveds : []) : [];
    @endphp
    <div class="header">
        <h1>Promociones canjeados</h1>
    </div>

    <div class="summary">
    <h2>Cliente: {{ $customer->name ?? '-' }}</h2>
    <h3><strong>Puntos disponible:</strong> {{ $cliente->points ?? 0 }}</h3>
    </div>

    <h3>Productos canjeados:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Puntos gastados</th>
                <th>Cantidad canjeados</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ is_array($item) ? ($item['product'] ?? '-') : ($item->product ?? '-') }}</td>
                    <td>{{ is_array($item)
                        ? ('-' . number_format((float)($item['points'] ?? 0), 2))
                        : ('-' . number_format((float)($item->points ?? 0), 2)) }}</td>
                    <td>{{ is_array($item)
                        ? ('-' . (int)($item['quantity'] ?? 0))
                        : ('-' . (int)($item->quantity ?? 0)) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No hay productos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
