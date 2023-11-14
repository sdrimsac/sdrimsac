<style>
    .text-center {
        text-align: center;
    }

    .font-weight {
        font-weight: bold;
    }
</style>
@php
    $col_span = 26;
@endphp
<table border="0" cellspacing="0">
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight">{{ $company['name'] }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight">{{ $company['number'] }}</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="font-weight">Moneda: SOLES</td>
    </tr>
    <tr>
        <td colspan="{{ $col_span }}" class="text-center font-weight">FORMATO 14.1 : "REGISTRO DE VENTAS E INGRESOS
            DEL PERIODO {{ $period }}"</td>
    </tr>
    <tr>
        <td class="border-left font-weight">
            Nº CUO.
        </td>
        <td class="border-left font-weight">
            FECHA DE EMISION DEL COMPROBANTE DEL DOCUMENTO
        </td>

        <td colspan="3" class="border-left font-weight">
            COMPROBANTE DE PAGO
        </td>
        <td colspan="3" class="border-left font-weight">
            INFORMACON DE CLIENTE
        </td>
        <td class="border-left font-weight">
            VALOR<br />FACTURADO<br />EXPORTACION
        </td>
        <td class="border-left font-weight">
            BASE<br />IMPONIBLE<br />GRAVADA
        </td>
        <td colspan="2" class="border-left font-weight">
            IMPORTE TOTAL
        </td>
        <td class="border-left font-weight">
            DESCUENTO
        </td>
        <td class="border-left font-weight">
            ISC
        </td>
        <td class="border-left font-weight">VENTA DIFERIDA</td>
        <td class="border-left font-weight">
            IGV Y/O<br />IMP.
        </td>

        <td lass="border-left font-weight">
            IMPORTE TOTAL
        </td>
        <td class="border-left font-weight">
            ESTADO
        </td>
        <td class="border-left font-weight">
            TIPO VENTA
        </td>
        <td colspan="4" class="border-left font-weight">
            REFERENCIA DEL COMPROBANTE O<br />
            DOC. ORIGINAL QUE SE MODIFICA
        </td>
    </tr>
    <tr>
        <td class="border-left"></td>

        <td class="border-left font-weight"></td>
        <td class="border-left font-weight">TIPO</td>
        <td class="border-left font-weight">SERIE</td>
        <td class="border-left font-weight">NUMERO</td>
        <td class="border-left font-weight">TIPO</td>
        <td class="border-left font-weight">R.U.C.</td>
        <td class="border-left font-weight">APELLIDOS Y NOMBRES</td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight">EXONERADA</td>
        <td class="border-left font-weight">INAFECTA</td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>
        <td class="border-left font-weight"></td>


        <td class="border-left"></td>
        <td class="border-left"></td>
        <td class="border-left">FECHA</td>
        <td class="border-left">TIPO</td>
        <td class="border-left">SERIE</td>
        <td class="border-left">Nro.COMP.</td>
    </tr>
    @foreach ($records as $row)
        <?php
        //dd($row['items'][0]->item->unit_type_id);
        ?>
        <tr>
            <td class="border-left">{{ $loop->iteration }}</td>
            <td class="border-left">{{ \Carbon\Carbon::parse($row['date_of_issue'])->format('d/m/Y') }}</td>

            <td class="border-left">{{ $row['document_type_id'] }}</td>
            <td class="border-left">{{ $row['series'] }}</td>
            <td class="border-left">{{ $row['number'] }}</td>
            <td class="border-left">{{ $row['customer_identity_document_type_id'] }}</td>
            <td class="border-left">{{ $row['customer_number'] }}</td>
            <td class="border-left">{{ $row['customer_name'] }}</td>

            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exportation'] }}
            </td>
            <td>{{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_taxed'] }}
            </td>
            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_exonerated'] }}
            </td>
            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_unaffected'] }}
            </td>
            <td class="border-left">
                {{$row['total_discount']}}

            </td>
            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_plastic_bag_taxes'] }}
            </td>
            <td class="border-left"></td>
            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total_igv'] }}
            </td>

            <td class="border-left">
                {{ in_array($row['document_type_id'], ['01', '03']) && in_array($row['state_type_id'], ['09', '11']) ? 0 : $row['total'] }}
            </td>
            @if ($row['state_type_id'] == '01')
                <td class="border-left">Registrado</td>
            @endif
            @if ($row['state_type_id'] == '03')
                <td class="border-left">Enviado</td>
            @endif
            @if ($row['state_type_id'] == '05')
                <td class="border-left">Aceptado</td>
            @endif
            @if ($row['state_type_id'] == '07')
                <td class="border-left">Observado</td>
            @endif
            @if ($row['state_type_id'] == '09')
                <td class="border-left">Rechazado</td>
            @endif
            @if ($row['state_type_id'] == '11')
                <td>Anulado</td>
            @endif
            @if ($row['state_type_id'] == '13')
                <td class="border-left">Por anular</td>
            @endif
  

            <td class="border-left">
                @if (isset($row['items']) && count($row['items']) > 0)
                    @if ($row['items'][0]->item->unit_type_id != 'ZZ')
                        P
                    @else
                        S
                    @endif
                @endif
            </td>
            @if (isset($row['affected_document']))
                <td class="border-left">{{ $row['affected_document']['date_of_issue'] }}</td>
                <td class="border-left">{{ $row['affected_document']['document_type_id'] }}</td>
                <td class="border-left">{{ $row['affected_document']['series'] }}</td>
                <td class="border-left">{{ $row['affected_document']['number'] }}</td>
            @else
                <td class="border-left"></td>
                <td class="border-left"></td>
                <td class="border-left"></td>
                <td class="border-left"></td>
            @endif
        </tr>
    @endforeach
</table>
