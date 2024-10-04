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
            <tr>
                <td colspan="2">
                    <p>
                        <strong>Número de cotizaciones:</strong> {{ $count }}
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <br>

    @if (!empty($records))
        <div class="">
            <div class=" ">

                <table width="100%" class="">

                    <tr>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">#
                        </th>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            CODIGO</th>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            PRODUCTO</th>

                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            CANTIDAD</th>
                    </tr>
                    <tbody>
                        @php
                            $total = 0;
                            $total_quantity = 0;
                        @endphp
                        @foreach ($records as $idx => $value)
                            @php
                                $total += $value->total;
                                $total_quantity += $value->total_quantity;
                            @endphp

                            <tr>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->item_internal_id }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->item_description }}
                                </td>

                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->total_quantity }}

                                </td>



                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; padding: 8px; border: 1px solid #ddd;">
                                <strong>TOTAL</strong>
                            </td>
                            <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                <strong>S/ {{ $total }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>
    @endif
    @if (!empty($bonusItems))
        <div class="">
            <div class=" ">

                <table width="100%" class="">
                    <tr>
                        <th colspan="4"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            <strong>BONIFICACIONES</strong>
                        </th>
                    </tr>
                    <tr>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">#
                        </th>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            CODIGO</th>
                        <th class="encabezado"
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            PRODUCTO</th>
                        <th class="encabezado
                            "
                            style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #ddd;">
                            CANTIDAD</th>
                    </tr>
                    <tbody>
                        @php
                            $total_quantity = 0;
                        @endphp
                        @foreach ($bonusItems as $idx => $value)
                            @php
                                $total_quantity += $value->quantity;
                            @endphp

                            <tr>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $loop->iteration }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->internal_id }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->description }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $value->quantity }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; padding: 8px; border: 1px solid #ddd;">
                                <strong>TOTAL</strong>
                            </td>
                            <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                <strong>{{ $total_quantity }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros de bonificación.</p>
                </div>
    @endif


</body>

</html>
