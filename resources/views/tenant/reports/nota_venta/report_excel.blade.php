<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compras</title>
</head>
<!-- esto el el repote de nota de venta -->

<body>
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td colspan="8"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                        <h3 align="center" class="title"><strong>Reporte Productos Vendidos Nota de Venta</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{ $company->name }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong>{{ $company->number }}</p>
                    </td>
                    <td align="center" colspan="4"
                        style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong>{{ date('Y-m-d') }}</p>
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
                                {{-- <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#
                                </th> --}}
                                <th class="text-center"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Numero</th>
                                <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Flecha De Emision</th>
                                <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Establecimiento</th>
                                <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Codigo Interno</th>
                                <th class="text-center"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Producto</th>
                                <th class="text-right"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Cantidad</th>
                                <th class="text-right"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Precio</th>
                                <th class="text-right"
                                    style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $record)
                                @php
                                    $establishment = App\Models\Tenant\Establishment::find($record->establishment_id);
                                    $establishment_description = $establishment ? $establishment->description : null;
                                @endphp
                                @foreach ($record->items as $index => $item)
                                    <tr>
                                        @if ($index === 0)
                                            <td rowspan="{{ count($record->items) }}" style="border: 1px solid black;">
                                                {{ $record->number_full }}
                                            </td>

                                            <td rowspan="{{ count($record->items) }}" style="border: 1px solid black;">
                                                {{ \Carbon\Carbon::parse($record->date_of_issue)->format('d-m-Y') }}
                                            </td>
                                        @endif
                                        <td style="border: 1px solid black;">{{ $establishment_description }}</td>
                                        <td style="border: 1px solid black;">{{ $item->item->internal_id }}</td>
                                        <td style="border: 1px solid black;">{{ $item->item->description }}</td>
                                        <td style="border: 1px solid black;">{{ number_format($item->quantity, 2) }}
                                        </td>
                                        <td class="text-end" style="border: 1px solid black;">
                                            {{ number_format($item->unit_value, 2) }}</td>
                                        <td class="text-end" style="border: 1px solid black;">
                                            {{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </table>
@else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>
