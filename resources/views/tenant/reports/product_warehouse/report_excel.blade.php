<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Lista de stock</strong></h3>
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
                    <p><b>Establecimiento: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $establishment->description }}</strong></p>
                </td>
                <td>
                    <p><strong>Cajero: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ $user->name }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
                <td>
                    <p><strong>Turno:</strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ $turn }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            <tr>
                                <td class="celda">{{ $key + 1 }}</td>
                                <td class="celda">&nbsp;{{ $value['internal_id'] }}</td>
                                <td class="celda">{{ $value['category'] }}</td>
                                <td class="celda">{{ $value['description'] }}</td>
                                <td class="celda">{{ $value['unit_type_id'] }}</td>
                                <td class="celda">{{ $value['stock'] }}</td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div>
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
