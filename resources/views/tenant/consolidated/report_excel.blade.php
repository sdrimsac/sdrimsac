<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Consolidado</strong></h3>
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
                    <p><strong>Fecha de consolidacion: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ $consolidated->date_of_issue }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">

                <table width="100%" class="">

                    <tr>
                        <th class="encabezado">#</th>
                        <th class="encabezado">PRODUCTO</th>
                        <th class="encabezado">PRESENTACION</th>
                        <th class="encabezado">CANTIDAD</th>
                    </tr>
                    <tbody>
                        @foreach ($records as $idx => $value)
                    
                            <tr>
                                <td>
                                    {{
                                        $loop->iteration 
                                    }}
                                </td>
                                <td>
                                    {{ $value->item_description }}
                                </td>
                                <td>
                                    {{ $value->unit_type_description }}
                                </td>
                                <td>
                                    {{ $value->total_quantity }}

                                </td>
                                

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>
    @endif
</body>

</html>
