<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Delivery</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .center {
            text-align: center;
        }
        .border-bottom {
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>
<body>

    <div class="center">
        <strong>DATA DESARROLLO</strong><br>
        20100077707<br>
        Jr Arequipa 325<br>
        (51) 939186482<br>
        <br>
        <strong>DELIVERY</strong><br>
        Pedido Nº {{ $orden->id }}<br><br>
    </div>

    <div>
        <strong>CLIENTE:</strong> {{ $orden->cliente }}<br>
        <strong>DIRECCIÓN:</strong> {{ $orden->direccion }}<br>
        <strong>REFERENCIA:</strong> {{ $orden->referencia }}<br>
        <strong>CELULAR:</strong> {{ $orden->celular }}<br>
        <strong>FECHA EMISIÓN:</strong> {{ $orden->fecha_emision }}<br><br>
    </div>

    <table>
        <thead>
            <tr>
                <th>CANT.</th>
                <th>PRODUCTO</th>
                <th>PRECIO</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->items as $item)
                <tr>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ number_format($item->precio, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <table>
        <tr>
            <td colspan="3" class="right">Sub Total S/</td>
            <td>{{ number_format($orden->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="right">Costo envío S/</td>
            <td>{{ number_format($orden->costo_envio, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="right"><strong>Total S/</strong></td>
            <td><strong>{{ number_format($orden->total, 2) }}</strong></td>
        </tr>
    </table>

    <br><br>
    <div class="center">
        Gracias por su compra
    </div>

</body>
</html>
