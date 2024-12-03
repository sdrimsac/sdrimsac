<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de Productos Con Garantia</title>
</head>

<body>

    <div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="8">
                    <h3 class="text-center fw-bold">
                        Lista de Productos Con Garantia
                    </h3>
                </td>
            </tr>
            <tr>
                <td class="headers" height="20" colspan="6">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="headers" colspan="2">
                    <strong>Fecha: </strong>{{ date('Y-m-d') }}
                </td>
            </tr>
            <tr class="nth-child">
                <td class="headers" height="20" colspan="8">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
            </tr>
        </table>
    </div>

    @if ($records->isNotEmpty())
        <div>
            <table>
                <tbody>
                    <tr>
                        <td class="encabezado" style="border: 1px solid black;">#</td>
                        <td class="encabezado" style="border: 1px solid black">CODIGO</td>
                        <td class="encabezado" style="border: 1px solid black">PRODUCTO</td>
                        <td class="encabezado" style="border: 1px solid black">CLIENTE</td>
                        <td class="encabezado" style="border: 1px solid black">FECHA DE INICIO DE GARANTIA</td>
                        <td class="encabezado" style="border: 1px solid black">TIEMPO DE GARANTIA</td>
                        <td class="encabezado" style="border: 1px solid black">FECHA FINAL DE GARANTIA</td>
                        <td class="encabezado" style="border: 1px solid black">TIEMPO RESTANTE DE GARANTIA</td>
                    </tr>

                    @foreach ($records as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row['internal_id'] }}</td>
                            <td>{{ $row['description'] }}</td>
                            <td>{{ $row['customer_name'] }}</td>
                            <td>{{ $row['warranty_start_date'] }}</td>
                            <td>{{ $row['month_day'] }} meses</td>
                            <td>{{ $row['warranty_end_date'] }}</td>
                            <td>
                                @php
                                    $start_date = \Carbon\Carbon::parse($row['warranty_start_date']);
                                    $end_date = \Carbon\Carbon::parse($row['warranty_end_date']);
                                    $remaining_days = $end_date->diffInDays(\Carbon\Carbon::now());
                                @endphp
                                {{ $remaining_days }} días
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
