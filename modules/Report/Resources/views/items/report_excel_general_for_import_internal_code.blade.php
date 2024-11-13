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

    @if (!empty($records))
        
                <table class="">
                    <thead>
                        <tr>
                            <th>Código interno</th>
                            <th>Descripción</th>
                            <th>Valor de puntos</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            
                            <tr>
                                <td>{{ $value->internal_id }}</td>
                                <td>{{ $value->description }}</td>
                                <td>{{ $value->points_value }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
    @else
        <div>
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
