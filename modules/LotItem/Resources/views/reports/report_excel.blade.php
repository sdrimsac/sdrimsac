<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Reporte Inventario</strong></h3>
    </div>
    <br>
    <div style="margin-top:20px; margin-bottom:15px;">
        <table>
            <tr>
                <td>
                    <p><b>Empresa: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $company->name }}</strong></p>
                </td>
                <td>
                    <p><strong>Fecha: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ date('Y-m-d') }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
                <td>
                    <p><strong>Establecimiento: </strong></p>
                </td>
                <td align="center">{{ $establishment->address }} - {{ $establishment->department->description }} -
                    {{ $establishment->district->description }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))



        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th>#</th>
                <th>Serie</th>
                <th>Producto</th>
                <th>Fecha</th>
                <th>Almacén</th>
                <th>Vendido</th>
                <th>Estado</th>
            </tr>

            @foreach ($records as $record)
                <tr>
                    <td class="celda">{{ $loop->iteration }}</td>
                    <td class="celda">{{ $record->series }}</td>
                    <td class="celda">{{ $record->item->description }}</td>
                    <td class="celda">{{ $record->date }}</td>
                    <td class="celda">{{ $record->warehouse->description }}</td>
                    <td class="celda">{{ $record->has_sale ? "Sí":"No" }}</td>
                    <td class="celda">{{ $record->state }}</td>
                </tr>
            @endforeach
            <tbody>
        </table>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
