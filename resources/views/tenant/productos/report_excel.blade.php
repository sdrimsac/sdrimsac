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
@php
    $conteo = 0;
@endphp

<body>
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td colspan="6"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 14px;">
                        <h3 align="center" class="title"><strong>Reporte Inventario</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3"
                        style=" border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{ $company->name ?? '' }} </p>
                    </td>
                    <td align="center" colspan="3"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong> {{ date('Y-m-d') }} </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="2"
                        style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong> {{ $company->number ?? '' }} </p>
                    </td>
                    <td align="center" colspan="4"
                        style="text-align: center; border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Establecimiento: </strong>{{ $establishment->address ?? '' }} -
                            {{ $establishment->department->description ?? '' }} -
                            {{ $establishment->district->description ?? '' }}</p>
                    </td>
                </tr>
            </table>
        </div>

        @if (!empty($records))

            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            #</th>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            Descripción</th>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            Almacén</th>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            Stock </th>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            Fecha</th>
                        <th style="text-align: center; border: 2px solid black; background-color: #DCDCDC;">
                            Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $key => $value)
                        @php
                            if ($key == 0) {
                                dump($value);
                            }
                            $lots = json_decode($value->lots, true);
                        @endphp
                        <tr>
                            <td style="text-align: center; border: 2px solid black;">{{ $key + 1 }}</td>
                            <td style="text-align: center; border: 2px solid black;">
                                {{ $value->item->description }}
                                <br>
                                {{ $value->lot_code }}
                                @isset($lots)
                                    @if (count($lots) > 0)
                                        @foreach ($lots as $lot)
                                            <p>
                                                <small>{{ $lot['series'] }}</small>
                                            </p>
                                        @endforeach
                                    @endif
                                @endisset 
                            </td>
                            <td style="text-align: center; border: 2px solid black;">
                                {{ $value->warehouse->description }}
                            </td>
                            <td style="text-align: center; border: 2px solid black;">
                                {{ $value->quantity }}
                            </td>
                            <td style="text-align: center; border: 2px solid black;">
                                {{ $value->created_at->format('d/m/Y') }}
                            </td>
                            <td style="text-align: center; border: 2px solid black;">
                                {{ $value->inventoryTransaction->type == 'output' ? 'Salida' : 'Entrada' }}
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
