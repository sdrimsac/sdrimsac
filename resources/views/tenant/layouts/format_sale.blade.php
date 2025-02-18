// ...existing code...

<tr>
    <td colspan="{{ $col_span }}" class="text-center font-bold border-bottom">BOLETAS DE VENTA</td>
</tr>
@php
    $total_suma_boletas = 0;
    $total_resta_boletas = 0;
@endphp
@foreach ($records as $row)
    @if (substr($row['series'], 0, 1) === 'B')
        <tr>
            {{-- Misma estructura de columnas que tenías antes --}}
            <td class="border-left">{{ $loop->iteration }}</td>
            <td class="border-left">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
            // ...resto de las columnas...
        </tr>
        @php
            if ($row['document_type_id'] === '07') {
                $total_resta_boletas += $row['total'];
            } else {
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_suma_boletas += $row['total'];
                }
            }
        @endphp
    @endif
@endforeach
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total Boletas Emitidas:</td>
    <td class="border-left">{{ number_format($total_suma_boletas + $total_resta_boletas, 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total Notas de Crédito Boletas:</td>
    <td class="border-left">{{ number_format($total_resta_boletas, 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total a Declarar Boletas:</td>
    <td class="border-left">{{ number_format($total_suma_boletas, 2) }}</td>
</tr>

<tr>
    <td colspan="{{ $col_span }}" class="text-center font-bold border-bottom">FACTURAS</td>
</tr>
@php
    $total_suma_facturas = 0;
    $total_resta_facturas = 0;
@endphp
@foreach ($records as $row)
    @if (substr($row['series'], 0, 1) === 'F')
        <tr>
            {{-- Misma estructura de columnas que tenías antes --}}
            <td class="border-left">{{ $loop->iteration }}</td>
            <td class="border-left">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
            // ...resto de las columnas...
        </tr>
        @php
            if ($row['document_type_id'] === '07') {
                $total_resta_facturas += $row['total'];
            } else {
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_suma_facturas += $row['total'];
                }
            }
        @endphp
    @endif
@endforeach
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total Facturas Emitidas:</td>
    <td class="border-left">{{ number_format($total_suma_facturas + $total_resta_facturas, 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total Notas de Crédito Facturas:</td>
    <td class="border-left">{{ number_format($total_resta_facturas, 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total a Declarar Facturas:</td>
    <td class="border-left">{{ number_format($total_suma_facturas, 2) }}</td>
</tr>

<tr>
    <td colspan="{{ $col_span }}" class="text-center font-bold border-bottom">TOTALES GENERALES</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total General Emitido:</td>
    <td class="border-left">{{ number_format(($total_suma_boletas + $total_resta_boletas) + ($total_suma_facturas + $total_resta_facturas), 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total General Notas de Crédito:</td>
    <td class="border-left">{{ number_format($total_resta_boletas + $total_resta_facturas, 2) }}</td>
</tr>
<tr>
    <td colspan="{{ $col_span - 7 }}" class="text-right font-bold">Total General a Declarar:</td>
    <td class="border-left">{{ number_format($total_suma_boletas + $total_suma_facturas, 2) }}</td>
</tr>

// ...existing code...
