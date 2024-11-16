<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Productos Vendidos</title>
</head>

<body>

    <div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="5" style="border: 1px solid black;">
                    <h3 class="headers text-center">
                        Lista de Producto Vendido por Vendedor
                    </h3>
                </td>
            </tr>
            <tr>
                <td class="headers" height="20" colspan="5" style="border: 1px solid black">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>

            </tr>
            <tr>
                <td class="headers" colspan="5" style="border: 1px solid black">
                    <strong>Fecha: </strong>{{ date('Y-m-d') }}
                </td>

            </tr>
            <tr class="nth-child">
                <td class="headers" height="20" colspan="5" style="border: 1px solid black">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
            </tr>
        </table>
    </div>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td class="fw-bold" colspan="" style="border: 1px solid black">vendedor: </td>
                                <td colspan="4" style="border: 1px solid black">{{ $record['name'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <td class="encabezado" style="border: 1px solid black; color: rgb(0, 0, 0)">#</td>
                            <td class="encabezado" style="border: 1px solid black; color: rgb(0, 0, 0)">PRODUCTO</td>
                            <td class="encabezado" style="border: 1px solid black; color: rgb(0, 0, 0)" >CANTIDAD</td>
                            <td class="encabezado" style="border: 1px solid black; color: rgb(0, 0, 0)">PRECIO</td>
                            <td class="encabezado" style="border: 1px solid black; color: rgb(0, 0, 0)">TOTAL</td>
                        </tr>
                        <thead>
                            @foreach ($records as $record)
                                @foreach ($record['combined_items'] as $item)
                                    <tr>
                                        <td style="border: 1px solid black">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid black">{{ $item['description'] }}</td>
                                        <td style="border: 1px solid black">{{ $item['quantity'] }}</td>
                                        <td style="border: 1px solid black">{{ number_format($item['unit_price'], 2) }}</td>
                                        <td style="border: 1px solid black">{{ number_format($item['total_price'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </thead>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>

    @endif
</body>


</html>
