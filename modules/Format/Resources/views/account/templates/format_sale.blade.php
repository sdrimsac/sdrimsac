<style>
    .text-center {
        text-align: center;
    }

    .font-weight {
        font-weight: bold;
    }
</style>
@php
    $col_span = 23;
    $total_suma_boletas = 0;
    $total_resta_boletas = 0;
    $total_suma_facturas = 0;
    $total_resta_facturas = 0;
@endphp
<table border="0" cellspacing="0">
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight border-left" style="border: 1px solid black;">{{ $company['name'] }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight border-left" style="border: 1px solid black;">{{ $company['number'] }}
        </td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight border-left" style="border: 1px solid black;">Moneda: SOLES</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight border-left" style="border: 1px solid black;">FORMATO 14.1
            : "REGISTRO DE VENTAS E INGRESOS
            DEL PERIODO {{ $period }}"</td>
    </tr>
    <tr>
        <td class="border-left font-weight" style="border: 1px solid black;">
            Nº CUO.
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            FECHA DE EMISION DEL COMPROBANTE DEL DOCUMENTO
        </td>

        <td colspan="3" class="border-left font-weight" style="border: 1px solid black;">
            COMPROBANTE DE PAGO
        </td>
        <td colspan="3" class="border-left font-weight" style="border: 1px solid black;">
            INFORMACON DE CLIENTE
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            VALOR<br />FACTURADO<br />EXPORTACION
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            BASE<br />IMPONIBLE<br />GRAVADA
        </td>
        <td colspan="2" class="border-left font-weight" style="border: 1px solid black;">
            IMPORTE TOTAL
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            DESCUENTO
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            ISC
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">VENTA DIFERIDA</td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            IGV Y/O<br />IMP.
        </td>

        <td class="border-left font-weight" style="border: 1px solid black;">
            IMPORTE TOTAL
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            TIPO DE CAMBIO
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            ESTADO
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">
            TIPO VENTA
        </td>
        <td colspan="4" class="border-left font-weight" style="border: 1px solid black;">
            REFERENCIA DEL COMPROBANTE O<br />
            DOC. ORIGINAL QUE SE MODIFICA
        </td>
        <td class="border-left font-weight" style="border: 1px solid black;">DOC. AFECTADO</td>
        <td class="border-left font-weight" style="border: 1px solid black;">DOC. NC</td>
    </tr>
    <tr>
        <td class="border-left"></td>

        <td class="border-left font-weight"></td>
        <td class="border-left font-weight" style="border: 1px solid black;">TIPO</td>
        <td class="border-left font-weight" style="border: 1px solid black;">SERIE</td>
        <td class="border-left font-weight" style="border: 1px solid black;">NUMERO</td>
        <td class="border-left font-weight" style="border: 1px solid black;">TIPO</td>
        <td class="border-left font-weight" style="border: 1px solid black;">R.U.C.</td>
        <td class="border-left font-weight" style="border: 1px solid black;">APELLIDOS Y NOMBRES</td>
        {{-- <td class="border-left font-weight">DOC. AFECTADO</td> --}}
        <td class="border-left font-weight" style="border: 1px solid black;"></td>
        <td class="border-left font-weight" style="border: 1px solid black;"></td>
        <td class="border-left font-weight" style="border: 1px solid black;">EXONERADA</td>
        <td class="border-left font-weight" style="border: 1px solid black;">INAFECTA</td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>

        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>


        <td class="border-left"></td>
        <td class="border-left"></td>
        <td class="border-left" style="border: 1px solid black;">FECHA</td>
        <td class="border-left" style="border: 1px solid black;">TIPO</td>
        <td class="border-left" style="border: 1px solid black;">SERIE</td>
        <td class="border-left" style="border: 1px solid black;">Nro.COMP.</td>
    </tr>

    {{-- Sección Boletas --}}
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight border-bottom" style="background-color: #e8e8e8; border: 1px solid black;">BOLETAS DE VENTA</td>
    </tr>
    @foreach ($records as $row)
        @if (substr($row['series'], 0, 1) === 'B' && substr($row['series'], 0, 2) !== 'BC')
            <tr>
                <td class="border-left" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['series'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_identity_document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_name'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exportation'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_taxed'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exonerated'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_unaffected'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['total_discount'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_plastic_bag_taxes'] }}</td>
                <td class="border-left" style="border: 1px solid black;"></td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_igv'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total'] }}</td>
                <td class="border-left" style="border: 1px solid black;">
                    @if (!$row['is_pen'])
                    {{ $row['exchange_rate_sale'] }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['state_type_id'] === '01' ? 'Registrado' : ($row['state_type_id'] === '03' ? 'Enviado' : ($row['state_type_id'] === '05' ? 'Aceptado' : ($row['state_type_id'] === '07' ? 'Observado' : ($row['state_type_id'] === '09' ? 'Rechazado' : ($row['state_type_id'] === '11' ? 'Anulado' : ($row['state_type_id'] === '13' ? 'Por anular' : '')))))) }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ isset($row['items']) && count($row['items']) > 0 ? ($row['items'][0]->item->unit_type_id != 'ZZ' ? 'P' : 'S') : '' }}</td>
                {{-- Columnas de documento afectado --}}
                @if (isset($row['affected_document']))
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['date_of_issue'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['document_type_id'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['series'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['number'] }}</td>
                @else
                    <td class="border-left"></td><td class="border-left"></td><td class="border-left"></td><td class="border-left"></td>
                @endif
            </tr>
            @php
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_suma_boletas += $row['total'];
                }
            @endphp
        @endif
    @endforeach

    {{-- Notas de Crédito de Boletas --}}
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight" style="background-color: #f8f9fa; border: 1px solid black;">Notas de Crédito - Boletas</td>
    </tr>
    @foreach ($records as $row)
        @if (substr($row['series'], 0, 2) === 'BC')
            <tr style="background-color: #fff3f3;">
                <td class="border-left" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['series'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_identity_document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_name'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exportation'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_taxed'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exonerated'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_unaffected'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['total_discount'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_plastic_bag_taxes'] }}</td>
                <td class="border-left"></td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_igv'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total'] }}</td>
                <td class="border-left" style="border: 1px solid black;">
                    @if (!$row['is_pen'])
                        {{ $row['exchange_rate_sale'] }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['state_type_id'] === '01' ? 'Registrado' : ($row['state_type_id'] === '03' ? 'Enviado' : ($row['state_type_id'] === '05' ? 'Aceptado' : ($row['state_type_id'] === '07' ? 'Observado' : ($row['state_type_id'] === '09' ? 'Rechazado' : ($row['state_type_id'] === '11' ? 'Anulado' : ($row['state_type_id'] === '13' ? 'Por anular' : '')))))) }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ isset($row['items']) && count($row['items']) > 0 ? ($row['items'][0]->item->unit_type_id != 'ZZ' ? 'P' : 'S') : '' }}</td>
                {{-- Columnas de documento afectado --}}
                @if (isset($row['affected_document']))
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['date_of_issue'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['document_type_id'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['series'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['number'] }}</td>
                @else
                    {{-- <td class="border-left"></td><td class="border-left"></td><td class="border-left"></td><td class="border-left"></td> --}}
                @endif
                {{-- <td class="border-left" style="border: 1px solid black;">
                    @if (isset($row['affected_document']))
                        B{{ $row['affected_document']['series'] }}-{{ str_pad($row['affected_document']['number'], 4, '0', STR_PAD_LEFT) }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">
                    {{ $row['series'] }}-{{ str_pad($row['number'], 4, '0', STR_PAD_LEFT) }}
                </td> --}}
            </tr>
            @php
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_resta_boletas += $row['total'];
                }
            @endphp
        @endif
    @endforeach

    {{-- Totales Boletas --}}
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total Boletas Emitidas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_suma_boletas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total Notas de Crédito Boletas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_resta_boletas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total a Declarar Boletas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_suma_boletas - $total_resta_boletas, 2) }}</td>
    </tr>

    {{-- Sección Facturas --}}
    <tr></tr>
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight border-bottom" style="background-color: #e8e8e8; border: 1px solid black;">FACTURAS</td>
    </tr>
    @foreach ($records as $row)
        @if (substr($row['series'], 0, 1) === 'F' && substr($row['series'], 0, 2) !== 'FC')
            <tr>
                <td class="border-left" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['series'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_identity_document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_name'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exportation'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_taxed'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exonerated'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_unaffected'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['total_discount'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_plastic_bag_taxes'] }}</td>
                <td class="border-left"></td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_igv'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total'] }}</td>
                <td class="border-left" style="border: 1px solid black;">
                    @if (!$row['is_pen'])
                        {{ $row['exchange_rate_sale'] }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['state_type_id'] === '01' ? 'Registrado' : ($row['state_type_id'] === '03' ? 'Enviado' : ($row['state_type_id'] === '05' ? 'Aceptado' : ($row['state_type_id'] === '07' ? 'Observado' : ($row['state_type_id'] === '09' ? 'Rechazado' : ($row['state_type_id'] === '11' ? 'Anulado' : ($row['state_type_id'] === '13' ? 'Por anular' : '')))))) }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ isset($row['items']) && count($row['items']) > 0 ? ($row['items'][0]->item->unit_type_id != 'ZZ' ? 'P' : 'S') : '' }}</td>
                {{-- Columnas de documento afectado --}}
                @if (isset($row['affected_document']))
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['date_of_issue'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['document_type_id'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['series'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['number'] }}</td>
                @else
                    <td class="border-left"></td><td class="border-left"></td><td class="border-left"></td><td class="border-left"></td>
                @endif
            </tr>
            @php
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_suma_facturas += $row['total'];
                }
            @endphp
        @endif
    @endforeach

    {{-- Notas de Crédito de Facturas --}}
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight" style="background-color: #f8f9fa; border: 1px solid black;">Notas de Crédito - Facturas</td>
    </tr>
    @foreach ($records as $row)
        @if (substr($row['series'], 0, 2) === 'FC')
            <tr style="background-color: #fff3f3;">
                <td class="border-left" style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['series'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_identity_document_type_id'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_number'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['customer_name'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exportation'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_taxed'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exonerated'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_unaffected'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['total_discount'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_plastic_bag_taxes'] }}</td>
                <td class="border-left" style="border: 1px solid black;"></td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_igv'] }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total'] }}</td>
                <td class="border-left" style="border: 1px solid black;">
                    @if (!$row['is_pen'])
                        {{ $row['exchange_rate_sale'] }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">{{ $row['state_type_id'] === '01' ? 'Registrado' : ($row['state_type_id'] === '03' ? 'Enviado' : ($row['state_type_id'] === '05' ? 'Aceptado' : ($row['state_type_id'] === '07' ? 'Observado' : ($row['state_type_id'] === '09' ? 'Rechazado' : ($row['state_type_id'] === '11' ? 'Anulado' : ($row['state_type_id'] === '13' ? 'Por anular' : '')))))) }}</td>
                <td class="border-left" style="border: 1px solid black;">{{ isset($row['items']) && count($row['items']) > 0 ? ($row['items'][0]->item->unit_type_id != 'ZZ' ? 'P' : 'S') : '' }}</td>
                {{-- Columnas de documento afectado --}}
                @if (isset($row['affected_document']))
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['date_of_issue'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['document_type_id'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['series'] }}</td>
                    <td class="border-left" style="border: 1px solid black;">{{ $row['affected_document']['number'] }}</td>
                @else
                    {{-- <td class="border-left" style="border: 1px solid black;"></td><td class="border-left" style="border: 1px solid black;"></td><td class="border-left" style="border: 1px solid black;"></td><td class="border-left" style="border: 1px solid black;"></td> --}}
                @endif
                <td class="border-left" style="border: 1px solid black;">
                    @if (isset($row['affected_document']))
                        F{{ $row['affected_document']['series'] }}-{{ str_pad($row['affected_document']['number'], 4, '0', STR_PAD_LEFT) }}
                    @endif
                </td>
                <td class="border-left" style="border: 1px solid black;">
                    {{ $row['series'] }}-{{ str_pad($row['number'], 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
            @php
                if (!in_array($row['state_type_id'], ['11', '09'])) {
                    $total_resta_facturas += $row['total'];
                }
            @endphp
        @endif
    @endforeach

    {{-- Totales Facturas --}}
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total Facturas Emitidas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_suma_facturas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total Notas de Crédito Facturas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_resta_facturas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total a Declarar Facturas:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_suma_facturas - $total_resta_facturas, 2) }}</td>
    </tr>

    {{-- Totales Generales --}}
    <tr></tr>
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight border-bottom" style="background-color: #e8e8e8; border: 1px solid black;">TOTALES GENERALES</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total General Emitido:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_suma_boletas + $total_suma_facturas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total General Notas de Crédito:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format($total_resta_boletas + $total_resta_facturas, 2) }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span - 7 }}" class="text-right font-weight" style="border: 1px solid black;">Total General a Declarar:</td>
        <td class="border-left" style="border: 1px solid black;">{{ number_format(($total_suma_boletas + $total_suma_facturas) - ($total_resta_boletas + $total_resta_facturas), 2) }}</td>
    </tr>
</table>
