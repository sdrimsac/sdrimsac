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
                    <p><strong>Fecha: </strong></p>
                </td>
                <td align="center">
                    <p><strong>
                            {{ date('d-m-Y') }}
                        </strong></p>
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
        @foreach ($records as $user_name => $zones)
        
            <table>
                <thead>
                    <tr>
                        <th colspan="3">
                            <h2>{{ $user_name }}</h2>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">#</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Documento</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Total</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Politica</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Cliente</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Zona</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($zones as $zone_name => $documents)
                        @php
                            $count_zone_items = count($documents);
                        @endphp
                        @foreach ($documents as $idx => $document)
                            <tr>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $document['num_orden'] }}
                                </td>         
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $document['number_full'] }}
                                </td>                       
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $document['total'] }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $document['unit_type'] }}
                                </td>
                                <td style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                    {{ $document['customer_name'] }}
                                </td>
                                @if ($loop->first)
                                    <td valign="middle" rowspan="{{ $count_zone_items }}"
                                        style="text-align: left; padding: 8px; border: 1px solid #ddd;">
                                        {{ $zone_name }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
        @endforeach
    @endif

</body>

</html>
