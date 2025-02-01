<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            page-break-after: always;
        }
        .card {
            width: 30%;
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background-color: #ffffff;
            margin-bottom: 20px;
            min-height: 250px;
            box-sizing: border-box;
        }
        .card img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .price {
            font-size: 20px;
            font-weight: bold;
            color: #000000;
            margin: 5px 0;
        }
        h4, p {
            margin: 5px 0;
            color: #000000;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Catálogo de Productos</h2>

    @foreach($items->chunk(6) as $chunk)
        <div class="container">
            @foreach($chunk as $item)
                <div class="card">
                    @if($item->image && file_exists(public_path('storage/uploads/items/' . $item->image)))
                        <img src="{{ public_path('storage/uploads/items/' . $item->image) }}" alt="">
                    @else
                        <img src="{{ public_path('logo/imagen-no-disponible.jpg') }}" alt="Imagen no disponible">
                    @endif
                    <h4>{{ $item->internal_id }}</h4>
                    <p>{{ $item->description }}</p>
                    <p class="price">S/. {{ number_format($item->sale_unit_price, 2) }}</p>
                </div>
            @endforeach
        </div>
        <div class="page-break"></div> <!-- Fuerza el salto de página -->
    @endforeach
</body>
</html>
