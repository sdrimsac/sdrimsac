<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div>
        <table>
            <tr>
                <td colspan="11"
                    style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                    <h3 align="center" class="title"><strong>Reporte De Venta Por Usuarios</strong></h3>
                </td>
            </tr>
            <tr>
                <td colspan="6"
                    style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td colspan="5"
                        style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        Reporte desde
                        {{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}
                        hasta {{ \Carbon\Carbon::parse($date_end)->format('d-m-Y') }}
                </td>

            </tr>
            <tr>
                @if ($user)
                    <td colspan="5"
                        style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <strong>Usuario: </strong>{{ $user->name }}
                    </td>
                @endif
                <td colspan="3"
                    style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
                <td colspan="3"
                    style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                    <strong>Establecimiento: </strong>{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }}
                </td>
            </tr>
        </table>
    </div>
    @if (!empty($boxes_report))
        <div class="">
            <div class=" ">
                @php
                    $totales_ingresos = 0;
                    $totales_egresos = 0;
                    $ingresos = 0;
                    $egresos = 0;
                    $depositos = 0;
                    $transferencia = 0;
                @endphp
                <table>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">#</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Fecha</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Operacion</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Ref</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Establecimiento</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Cliente</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">N° Identificacion</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Concepto</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Monto</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Usuario</td>
                            <td style="border: 1px solid black; background-color: #DCDCDC;">Condicion de Pago</td>

                        </tr>
                    <tbody>
                        @foreach ($boxes_report as $row)
                            @php
                                $establishment = App\Models\Tenant\Establishment::find($row->establishment_id);
                                $establishment_description = $establishment == null ? '' : $establishment->description;
                            @endphp
                            <?php
                            $amount = $row['amount'];
                            if (isset($row['document_id']) && $row['document_id'] != null) {
                                $document = \App\Models\Tenant\Document::find($row['document_id']);
                                $total = $document->total;
                                /* $payment_condition = $row_document->payment_condition_id == "01" ? "Contado" : "Crédito"; */
                                $payment_condition = $document->payment_condition_id == "01" ? "Contado" : "Crédito";
                                if ($total < $amount) {
                                    $amount = $total;
                                }
                                $date = $document->date_of_issue . ' ' . $document->time_of_issue;
                            }
                            if (isset($row['sale_note_id']) && $row['sale_note_id'] != null) {
                                $document = \App\Models\Tenant\SaleNote::find($row['sale_note_id']);
                                $payment_condition = $document->credit_cash !== 1 ? "Contado" : "Crédito";
                                $total = $document->total;
                                if ($total < $amount) {
                                    $amount = $total;
                                }
                                $date = $document->date_of_issue->format('Y-m-d') . ' ' . $document->time_of_issue;
                            }
                            if ($row['type'] == '1' && $row['method'] == 'Efectivo') {
                                $ingresos = $ingresos + $amount;
                            }
                            if ($row['type'] == '1' && $row['method'] == 'Depositos') {
                                $depositos = $depositos + $amount;
                            }
                            if ($row['type'] == '1' && $row['method'] == 'Transferencia') {
                                $transferencia = $transferencia + $amount;
                            }
                            
                            if ($row['type'] == '2') {
                                $egresos = $egresos + $amount;
                            }
                            $date = \Carbon\Carbon::parse($row['date'])->format('d-m-Y') . ' ' . \Carbon\Carbon::parse($row['created_at'])->format('h:m:s');
                            
                            ?>
                            <tr>
                                <td  style="border: 1px solid black;">{{ $loop->iteration }}</td>
                                <td style="border: 1px solid black;">
                                    {{ $date }}
                                </td>


                                @if ($row['type'] == '1' && $row['method'])
                                    <td style="border: 1px solid black;">{{ $row['method'] }}</td>
                                @endif

                                @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                    <td style="border: 1px solid black;">
                                        {{ $row['method'] }}
                                    </td>
                                @endif
                                <td style="border: 1px solid black;">{{ $row['cash']['reference_number'] }}</td>
                                @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                    <td style="border: 1px solid black;">
                                        {{ $row['subcategories']->subcategory }}
                                    </td>
                                @else
                                    @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                                        <td style="border: 1px solid black;">
                                            {{ $row['subcategories']->subcategory }}
                                        </td>
                                    @else
                                        <td style="border: 1px solid black;">
                                            {{ $establishment_description }}
                                        </td>
                                        @if ($row['sale_note_id'] != null && $row['document_id'] == null)
                                            <td style="border: 1px solid black;">
                                                {{ $row['salenote']['customer']->name }}
                                            </td>
                                            <td style="border: 1px solid black;">
                                                {{ $row['salenote']['customer']->number }}
                                            </td>
                                        @else
                                            @if ($row['sale_note_id'] != null && $row['document_id'] != null)
                                                <td style="border: 1px solid black;">
                                                    {{ $row['salenote']['customer']->name }}
                                                </td>
                                                <td style="border: 1px solid black;">
                                                    {{ $row['salenote']['customer']->number }}
                                                </td>
                                            @else
                                                @if ($row['document_id'] != null && $row['sale_note_id'] == null)
                                                    <td style="border: 1px solid black;">
                                                        {{ $row['document']['customer']->name }}
                                                    </td>
                                                    <td style="border: 1px solid black;">
                                                        {{ $row['document']['customer']->number }}
                                                    </td>
                                                @endif
                                            @endif
                                            {{-- <td>
                                                {{ $row['document']['customer']->number }}
                                            </td> --}}
                                        @endif
                                    @endif
                                @endif
                                <td style="border: 1px solid black;">{{ $row['description'] }}</td>
                                <td style="border: 1px solid black;">{{ $amount }}</td>
                                <td style="border: 1px solid black;">{{ $row['user']->name }}</td>
                                <td style="border: 1px solid black;">{{ $payment_condition }}</td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <table>
                    <tr>
                        <td colspan="10"></td>
                        <td class="categoria celda_right" style="border: 1px solid black;"><b>RESUMEN DE ARQUEO</b></td>
                    </tr>

                    <tr>
                        <td colspan="10"></td>
                        <td class="categoria celda_right" style="border: 1px solid black;">Ingresos - Venta : <b> S/.
                                {{ number_format(round($ingresos * 10) / 10, 2) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="10"></td>
                        <td class="categoria celda_right" style="border: 1px solid black;">Egresos : <b> S/.
                                {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                    </tr>



                    @if ($type_box == '2' && $type_box != null)
                        <tr>
                            <td colspan="10"></td>
                            <td class="categoria celda_right" style="border: 1px solid black;">Gastos - Egresos : <b> S/.
                                    {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                    @if ($depositos > 0.0 || $transferencia > 00)
                        <tr>
                            <td colspan="10"></td>
                            <td class="categoria celda_right" style="border: 1px solid black;">Depositos - Transferencia : <b> S/.
                                    {{ number_format(round(($depositos + $transferencia) * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                    @if ($type_box == '1' && $type_box != null)
                        <tr>
                            <td colspan="10"></td>
                            <td class="categoria celda_right" style="border: 1px solid black;">Totales : <b> S/.
                                    {{ number_format($ingresos - $egresos + $depositos + $transferencia, 2) }}</b>
                            </td>
                        </tr>
                        @if ($type_box == '2' && $type_box != null)
                            <tr>
                                <td colspan="10"></td>
                                <td class="categoria celda_right" style="border: 1px solid black;">Efectivo Gastos: <b> S/.
                                        {{ number_format(round($egresos * 10) / 10, 2) }}</b></td>
                            </tr>
                        @endif
                    @endif
                    @if ($type_box == '1' && $type_box != null)
                        <tr>
                            <td colspan="10"></td>
                            <td class="categoria celda_right" style="border: 1px solid black;">Efectivo : <b> S/.
                                    {{ number_format(round(($egresos + $ingresos) * 10) / 10, 2) }}</b></td>
                        </tr>
                    @endif
                </table>
            @else
                <div class="callout callout-info">
                    <p>No se encontraron registros.</p>
                </div>

    @endif
</body>

</html>
