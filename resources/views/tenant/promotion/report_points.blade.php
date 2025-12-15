<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Promociones disponible</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
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
    <div class="header">
        <h1>Promociones disponibles</h1>
        <!-- <h2>Cliente: {{ $customer->name }}</h2> -->
    </div>

    <div class="summary">
        <h2>Cliente: {{ $customer->name }}</h2>
        <!-- <p><strong>Puntos totales:</strong> {{ $points_available }}</p> -->
        <h3><strong>Puntos disponible:</strong> {{ $points }}</h3>
    </div>

    <h3>Productos disponibles por puntos:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Puntos requeridos</th>
                <th>Stock disponible</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['item_description'] ?? '-' }}</td>
                    <td>
                        <img src="{{ $item['image_url'] ?? asset('/logo/imagen-no-disponible.jpg') }}"
                            alt="Imagen del producto" width="50">
                    </td>
                    <td>{{ $item['item_points_value'] ?? 0 }}</td>
                    <td>{{ $item['item_quantity'] ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No hay productos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
