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
    <table>
        <tr>
            <td colspan="8"
                style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                <h3 align="center" class="title"><strong>Reporte De Productos vendidos</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Empresa:</strong>{{ $company->name }}</p>
            </td>
            {{-- <td colspan="4" style="border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Fecha Inicio: </strong>{{ date('Y-m-d') }}</p>  <b>Fecha Final</b>{{date('y-m-d')}}
            </td> --}}
            <td colspan="4"
                        style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        Reporte desde
                        {{ \Carbon\Carbon::parse($d_start)->format('d-m-Y') }}
                        hasta {{ \Carbon\Carbon::parse($d_end)->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Ruc: </strong>{{ $company->number }}</p>
            </td>
            <td colspan="4" style=" border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}} </p>
            </td>
        </tr>
        

        @if (!empty($records))
            <thead>
                <tr>
                    {{-- <th style="border: 1px solid black; background-color: #DCDCDC;">#</th> --}}
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Número</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Fecha emisión</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Establecimiento</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Codigo Interno</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Producto</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Cantidad</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Precio</th>
                    <th style="border: 1px solid black; background-color: #DCDCDC;">Total</th>
                </tr>
            </thead>
            <tbody> 
                @foreach ($records as $record)
                @php
                    $establishment = App\Models\Tenant\Establishment::find($record->establishment_id);
                    $establishment_description = $establishment ? $establishment->description : null;
                @endphp
                    @foreach ($record->items as $index => $item)
                   {{--  @dd($records) --}}
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ count($record->items) }}" style="border: 1px solid black;">
                                    {{ $record->number_full }}
                                </td>

                                <td rowspan="{{ count($record->items) }}" style="border: 1px solid black;">
                                    {{ $record->date_of_issue }}
                                </td>
                            @endif
                            <td style="border: 1px solid black;">{{ $establishment_description }}</td>
                            <td style="border: 1px solid black;">{{ $item->item->internal_id }}</td>
                            <td style="border: 1px solid black;">{{ $item->item->description }}</td>
                            <td style="border: 1px solid black;">{{ number_format($item->quantity, 2) }}</td>
                            <td class="text-end" style="border: 1px solid black;">{{ number_format($item->unit_value, 2) }}</td>
                            <td class="text-end" style="border: 1px solid black;">{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @php 
            $acum_total = 0;
            @endphp 
            @foreach ($records as $record)
            @foreach ($record->items as $item)
                @php
                    // Acumular el total de ventas del producto
                    $acum_total += $item->total;
                @endphp
            @endforeach
            @endforeach
                
                <tr>
                    <td colspan="7" style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #DCDCDC;">
                        Total de Productos Vendidos 
                    </td>

                    <td style="border: 1px solid black; text-align: right; font-weight: bold; background-color: #DCDCDC;">
                        {{ number_format($acum_total, 2) }}
                    </td>
                </tr>

            </tbody>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </table>
</body>

</html>
