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
            width: 100%;
            overflow: hidden;
            page-break-after: always;
            clear: both;
        }
        .card {
            width: 30%;
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background-color: #ffffff;
            float: left;
            margin: 1.5%;
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
        h4 {
            margin: 5px 0;
            color: #000000;
        }
        p {
            margin: 5px 0;
            color: #000000;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Catálogo de Productos</h2>

    @foreach($items->chunk(6) as $chunk)
        <div class="container">
            @foreach($chunk as $item)
                <div class="card">
                    @if($item->image)
                        <img src="{{ public_path('storage/uploads/items/' . $item->image) }}" alt="{{ $item->name }}">
                    @endif
                    <h4>{{ $item->internal_id }}</h4>
                    <p>{{ $item->description }}</p>
                    <p class="price">S/. {{ number_format($item->sale_unit_price, 2) }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>