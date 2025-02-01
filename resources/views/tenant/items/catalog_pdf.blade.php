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
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 180px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            
            /* Evita que las tarjetas se dividan entre páginas */
        }

        .card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card h4 {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }

        .card p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    {{-- <h2>Catálogo de Productos</h2> --}}
    <div class="container">
        @foreach ($grouped_records as $chunk)
            @foreach ($chunk as $record)
                <div class="card">
                    @if (!empty($record->image) && file_exists(public_path('storage/uploads/items/' . $record->image)))
                        <img src="{{ asset('storage/uploads/items/' . $record->image) }}"
                            alt="{{ $record->description }}">
                    @else
                        <img src="{{ asset('logo/imagen-no-disponible.jpg') }}" alt="Imagen no disponible">
                    @endif
                    <h4>{{ $record->internal_id }}</h4>
                    <p>{{ $record->description }}</p>
                    <p class="price">S/. {{ number_format($record->sale_unit_price, 2) }}</p>
                </div>
            @endforeach
        @endforeach
    </div>
</body>

</html>
