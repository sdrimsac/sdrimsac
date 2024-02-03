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
        <h3 align="center" class="title"><strong>Reporte Ingresos caja principal</strong></h3>
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
                        <th class="encabezado">FECHA DE APERTURA</th>
                        <th class="encabezado">CAJA</th>
                        <th class="encabezado">USUARIO</th>
                        <th class="encabezado">MONTO</th>
                        <th class="encabezado">OBS.</th>
                        <th class="encabezado">ESTADO</th>
                    </tr>
                    <tbody>
                        @foreach ($records as $idx => $row)
                            <?php
                            $cash = $row->cash;
                            $user_id = $cash->user_id;
                            $user = \App\Models\Tenant\User::find($user_id);
                            $user_name = $user->name;
                            $value = [
                                'user_name' => $user_name,
                                'id' => $row->id,
                                'cash_principal_id' => $row->cash_principal_id,
                                'cash_id' => $row->cash_id,
                                'comment' => $row->comment,
                                'amount' => $row->amount,
                                'status' => $row->status,
                                'status_description' => ($row->status ==  1) ? 'Pendiente' : (($row->status ==  2) ? 'Observado':'Aceptado'),
                                'active' => $row->active,
                                'cash_principal' => $row->cash_principal,
                                'cash' => $row->cash,
                            ];
                            ?>
                            <tr>
                                <td>
                                    {{ $idx + 1 }}
                                </td>
                                <td>
                                    {{ $value['cash']->date_opening }}
                                </td>
                                <td>
                                    {{ $value['cash']->reference_number }}
                                </td>
                                <td>
                                    {{ $value['user_name'] }}

                                </td>
                                <td>
                                    {{ $value['amount'] }}

                                </td>
                                <td>
                                    {{ $value['comment'] }}

                                </td>
                                <td>
                                    {{ $value['status_description'] }}
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
