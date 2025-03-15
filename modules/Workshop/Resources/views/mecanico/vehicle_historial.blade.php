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
            margin-top: 4px;
            page-break-inside: avoid;
        }

        table:first-of-type {
            margin-top: 0;
        }

        th,
        td {
            border: 1px solid black;
            padding: 1px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .header img {
            display: inline-block;
            vertical-align: middle;
        }

        .header h2 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
        }

        .header h4 {
            text-align: center;
            margin: 0;
            padding-top: 5px;
        }

        .h4 {
            margin: 0;
            padding: 40px;
        }

        @media print {
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Historial del Vehículo</h2>
        <img src="{{ $company_logo_path }}" alt="Company Logo" width="100" height="100">
    </div>
    <table>
        <tr>
            <td colspan="7" class="bold center">{{ $company_trade_name }}</td>
        </tr>
        <tr>
            <td class="bold" colspan="3">FECHA</td>
            <td colspan="4">{{ now()->format('Y-m-d') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="4" class="bold center">INFORMACION DEL CLIENTE</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">NOMBRE DEL CLIENTE</td>
            <td colspan="2">{{ $vehiculo->customer_name }}</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">DIRECCION</td>
            <td colspan="2">{{ $vehiculo->customer_address }}</td>
        </tr>
        <tr>
            <td class="bold">DNI</td>
            <td>{{ $vehiculo->customer_number }}</td>
            <td class="bold">CELULAR</td>
            <td>{{ $vehiculo->customer_telephone }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="bold center" colspan="4">INFORMACION DEL VEHICULO AUTOMOTRIZ</td>
        </tr>
        <tr>
            <td class="bold">PLACA</td>
            <td>{{ $vehiculo->placa }}</td>
            <td class="bold">TIPO VEHICULO</td>
            <td>{{ $vehiculo->tipo_vehiculo_description }}</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">MARCA</td>
            <td colspan="2">{{ $vehiculo->marca }}</td>
        </tr>
        <tr>
            <td class="bold">COLOR</td>
            <td>{{ $vehiculo->color }}</td>
            <td class="bold">SERIE</td>
            <td>{{ $vehiculo->serie }}</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">MOTOR</td>
            <td colspan="2">{{ $vehiculo->motor }}</td>
        </tr>
    </table>

    @foreach ($vehiculo->historial ?? collect([]) as $historia)
        <table>
            <tr>
                <td colspan="2" class="bold center">SERVICIOS REALIZADOS</td>
            </tr>
            <tr>
                <td class="bold">Fecha de atencion</td>
                <td>{{ $historia->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="bold">MECANICO</td>
                <td>{{ $historia->personal_name }}</td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <td colspan="3" class="bold center">SERVICIOS</td>
                </tr>
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
        <table>
            <thead>
                <tr>
                    <td colspan="5" class="bold center">PRODUCTOS</td>
                </tr>
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
        <table>
            <thead>
                <tr>
                    <td colspan="5" class="bold center">MOTIVO INGRESO</td>
                    <td colspan="5" class="bold center">TRABAJO REALIZADO</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">{{ $historia->observacion }}</td>
                    <td colspan="5">{{ $historia->motive }}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <tr>
                <td colspan="10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        </table>
        <div class="page-break"></div>
    @endforeach
</body>

</html>
