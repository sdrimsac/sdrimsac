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
    @php
    $zone = '';
    foreach ($records as $user_name => $zones) {
        foreach ($zones as $zone_name => $_) {
            $zone = $zone_name;
        }
    }
    @endphp
    <div style="margin-top:20px; margin-bottom:15px;">
        <table>

            <tr>
                <td colspan="5">
                    <h3 align="center" class="title"><strong>Consolidado de documentos</strong></h3>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p><b>Empresa: </b><strong>{{ $company->trade_name }}</strong></p>
                </td>
                <td colspan="1">
                    <p><strong>Fecha: {{ date('d-m-Y') }} </strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p><strong>Ruc: {{ $company->number }} </strong></p>
                </td>
                <td colspan="1">
                    <p><strong>Zona: {{ $zone }} </strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p><strong>Vehiculo: {{ $consolidated_info['vehicle_brand'] }} </strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p><strong>Placa: {{ $consolidated_info['plate_number'] }} </strong></p>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p><strong>Conductor: {{ $consolidated_info['driver_name'] }} </strong></p>
                </td>
            </tr>
        </table>
    </div>
    <br>
    @php
        $total_weight = 0;
        $total_documents;
        $total_paid = 0;
    @endphp
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
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Cliente</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Dirección</th>
                        <th style="text-align: left; padding: 8px; border: 1px solid #ddd;">Peso</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($zones as $zone_name => $documents)
                        @php
                            $count_zone_items = count($documents);
                        @endphp
                        @foreach ($documents as $idx => $document)
                            @php
                                $total_weight += $document['total_weight'];
                                if($document['paid']){
                                    $total_paid += 1;
                                }
                            @endphp
                            <tr>
                                <td

                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    {{ $document['num_orden'] }}
                                </td>
                                <td
                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    <span>{{ $document['number_full'] }}</span>
                                </td>
                                <td
                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    <span>{{ $document['total'] }}</span>
                                </td>

                                <td
                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    <span>{{ $document['customer_name'] }}</span>
                                </td>
                                <td
                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    <span>{{ $document['customer_address'] }}</span>
                                </td>
                                <td
                                    style="text-align: left; padding: 8px; border: 1px solid #ddd; {{ $document['state_type_id'] == '11' ? 'color: red;' : '' }}">
                                    <span>{{ $document['total_weight'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td>
                            <strong>{{ $total_weight }}</strong>
                        </td>
                    
                    </tr>
                    <tr>
                        <td colspan="6">
                    </tr>
                    <tr>
                        <td colspan="6">
                    </tr>
                    <tr>
                        <td>
                            <strong>DOCUMENTOS</strong>
                        </td>
                        <td>
                            <strong>{{ $consolidated_info['count_document'] }}</strong>
                        </td>
                        <td></td>
                        <td>
                            <strong>FACTURAS</strong>
                        </td>
                        <td>
                            <strong>{{ $consolidated_info['count_01'] }}</strong>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>CLIENTES</strong>
                        </td>
                        <td>
                            <strong>{{ $consolidated_info['count_diff_customer'] }}</strong>
                        </td>
                        <td></td>
                        <td>
                            <strong>BOLETAS</strong>
                        </td>
                        <td>
                            <strong>{{ $consolidated_info['count_03'] }}</strong>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <br>
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>TOTAL</strong>
                        </td>
                        <td>
                            <strong>{{ $consolidated_info['total'] }}</strong>
                        </td>
                        <td></td>
                        <td>
                            <strong>CONTADO</strong>
                        </td>
                        <td>
                            <strong>{{ $total_paid }}</strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @endforeach
    @endif

</body>

</html>
