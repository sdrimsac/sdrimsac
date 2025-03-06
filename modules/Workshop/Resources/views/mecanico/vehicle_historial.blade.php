<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial del Vehiculo global</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 class="center">Historial del Vehículo</h2>
    <table>
        <tr>
            <th>Cliente</th>
            <td>{{ $vehiculo->customer_name }}</td>
        </tr>
        <tr>
            <th>Placa</th>
            <td>{{ $vehiculo->placa }}</td>
        </tr>
        <tr>
            <th>Marca</th>
            <td>{{ $vehiculo->marca }}</td>
        </tr>
        <tr>
            <th>Color</th>
            <td>{{ $vehiculo->color }}</td>
        </tr>
        <tr>
            <th>Serie</th>
            <td>{{ $vehiculo->serie }}</td>
        </tr>
        <tr>
            <th>Motor</th>
            <td>{{ $vehiculo->motor }}</td>
        </tr>
    </table>

    @foreach ($vehiculo->historial ?? collect([]) as $historia)
        <h3>Atención Fecha: {{ $historia->created_at->format('d/m/Y') }}</h3>

        <h4>Servicios Realizados</h4>
        <h5>Mecanico: {{ $historia->personal_name }}</h5>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historia->servicesDetails ?? collect([]) as $index => $servicio)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $servicio->name }}</td>
                        <td>S/. {{ number_format($servicio->price_unit, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Productos:</h4>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Codigo Interno</th>
                    <th>Description</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historia->historialItem ?? collect([]) as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->item_internal_id }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>S/. {{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
