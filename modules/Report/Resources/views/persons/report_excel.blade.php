<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista clientes</title>
</head>

<body>

    <div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="14">
                    Lista de todo los Clientes
                </td>
            </tr>
            <tr>
                <td class="headers" height="20" colspan="7">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="headers" colspan="7">
                    <strong>Fecha: </strong>{{ date('Y-m-d') }}
                </td>
            </tr>
            <tr class="nth-child">
                <td class="headers" height="20" colspan="14">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table>
                    <tbody>
                        <tr>
                            <td class="encabezado">#</td>
                            <td class="encabezado">N° DOCUMENTO</td>
                            <td class="encabezado">NOMBRE/RAZON SOCIAL</td>
                            <td class="encabezado">NOMBRE COMERCIAL</td>
                            <td class="encabezado">CODIGO PAIS</td>
                            <td class="encabezado">DEPARTAMENTO</td>
                            <td class="encabezado">PROVINCIA</td>
                            <td class="encabezado">DISITRITO</td>
                            <td class="encabezado">DIRECCION</td>
                            <td class="encabezado">DIRECCION REAL CLIENTE</td>
                            <td class="encabezado">EMAIL</td>
                            <td class="encabezado">TELEFONO</td>

                        </tr>
                    <tbody>
                        @foreach ($records as $row)
                            <tr>
                                <td class="celda_loop">{{ $loop->iteration }}</td>
                                <td class="celda_left">{{ $row->number }}</td>
                                <td class="celda_left">{{ $row->name }}</td>
                                <td class="celda_left">{{ $row->trade_name }}</td>
                                <td class="celda_left">{{ $row->country_id}}</td>
                                <td class="celda_left">{{ $row->department_id}}</td>
                                <td class="celda_left">{{ $row->province_id}}</td>
                                <td class="celda_left">{{ $row->district_id}}</td>
                                <td class="celda_left">{{ $row->address }}</td>
                                <td class="celda_left">{{ $row->addess_secondary }}</td>
                                <td class="celda_left">{{ $row->email }}</td>
                                <td class="celda_left">{{ $row->telephone }}</td>
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
