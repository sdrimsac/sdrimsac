<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">

            <tr>
                <td colspan="8" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">
                    <h3 align="center" class="text-center"><strong>Reporte Documentos</strong></h3>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="border: 1px solid black; background-color: #DCDCDC;">
                    <p><b>Empresa: </b>{{ $company->name }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid black; background-color: #DCDCDC;">
                    <p><b>Ruc: </b>{{$company->number}}</p>
                </td>
                <td colspan="4" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">
                    <p><b>Fecha: </b>{{ date('Y-m-d') }}</p>
                </td>
            </tr>
        </div>
        <br>
        @if(!empty($records))
        <div class="">
            <div class=" ">
                @php
                $totales_ingresos=0;
                $totales_egresos=0;
                $depositos=0;
                $transferencia=0;
                $yape=0;
                $ingresos=0;
                $egresos=0;
                @endphp

                <tr>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">#</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Fecha</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Operacion</td>
                    <td class="encabezado" width="30" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Ref</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Cliente</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Concepto</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Monto</td>
                    <td class="encabezado" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Usuario</td>
                </tr>
                <tbody>
                    @foreach ($records as $row)
                    <?php
                    if ($row['type'] == '1' && $row['method'] == 'Efectivo') {
                        $ingresos = $ingresos + $row['amount'];
                    }
                    if ($row['type'] == '1' && $row['method'] == 'Depositos') {
                        $depositos = $depositos + $row['amount'];
                    }
                    if ($row['type'] == '1' && $row['method'] == 'Transferencia') {
                        $transferencia = $transferencia + $row['amount'];
                    }

                    if ($row['type'] == '2') {
                        $egresos = $egresos + $row['amount'];
                    }
                    $date = \Carbon\Carbon::parse($row['date'])->format('d-m-Y') . " " . \Carbon\Carbon::parse($row['created_at'])->format('h:m:s');

                    if (isset($row["document_id"]) && $row["document_id"] != null) {
                        $document = \App\Models\Tenant\Document::find($row["document_id"]);
                        $date = $document->date_of_issue . " " . $document->time_of_issue;
                    }
                    if (isset($row["sale_note_id"]) && $row["sale_note_id"] != null) {
                        $document = \App\Models\Tenant\SaleNote::find($row["sale_note_id"]);
                        $date = $document->date_of_issue->format('Y-m-d') . " " . $document->time_of_issue;
                    }
                    ?>
                    <tr>
                        <td class="celda_loop" style="border: 1px solid black; text-align: center;">{{ $loop->iteration }}</td>
                        <td class="celda_descrip" style="border: 1px solid black; text-align: center;">
                            {{$date}}
                        </td>


                        @if ($row['type'] == '1' && $row['method'])
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">{{$row['method']}}</td>
                        @endif

                        @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{$row['method']}}
                        </td>
                        @endif
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">{{$row["cash"]["reference_number"]}}</td>
                        @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{ $row['subcategories']->subcategory }}
                        </td>
                        @else
                        @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{ $row['subcategories']->subcategory }}
                        </td>
                        @else
                        @if ($row['sale_note_id'] != null && $row['document_id'] == null)
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{ $row['salenote']['customer']->name }}
                        </td>
                        @else
                        @if ($row['sale_note_id'] != null && $row['document_id'] != null)
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{ $row['salenote']['customer']->name }}
                        </td>
                        @else
                        @if ($row['document_id'] != null && $row['sale_note_id'] == null)
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">
                            {{ $row['document']['customer']->name }}
                        </td>
                        @endif
                        @endif
                        @endif
                        @endif
                        @endif
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">{{ $row['description'] }}</td>
                        <td class="celda_date" style="border: 1px solid black; text-align: center;">{{ $row['amount'] }}</td>
                        <td class="celda_left" style="border: 1px solid black; text-align: center;">{{ $row['user']->name }}</td>

                    </tr>
                    @endforeach

                </tbody>


                <tr>
                    <td colspan="6" class="categoria celda_right" style="border: 1px solid black; text-align: center;"></td>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;"><b>RESUMEN DE ARQUEO</b></td>
                </tr>
                <tr>
                    <td colspan="6" class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC">Ingresos - Venta : </td>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center;"><b> S/. {{$ingresos}}</b></td>
                </tr>
                <tr>

                    <td colspan="6" class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Egresos - Gastos : </td>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center;"><b> S/. {{$egresos}}</b></td>
                </tr>

                @if($type_box=="2" && $type_box!=null)
                <tr>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Gastos - Egresos : <b> S/. {{$egresos}}</b></td>
                </tr>
                @endif

                @if($depositos>0.00 || $transferencia>00)
                <tr>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Depositos - Transferencia : <b> S/. {{number_format($depositos+$transferencia,2)}}</b></td>
                </tr>
                @endif

                @if($type_box=="1" && $type_box!=null)
                <tr>
                    <td colspan="6" class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Totales</td>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center;"><b> S/. {{number_format(($ingresos-$egresos)+$depositos+$transferencia,2)}}</b></td>
                </tr>
                @endif

                @if($type_box=="2" && $type_box!=null)
                <tr>
                    <td class="categor1ia celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Efectivo Gastos: <b> S/. {{$egresos}}</b></td>

                </tr>
                @endif

                @if($type_box=="1" && $type_box!=null)
                <tr>
                    <td colspan="6" class="categoria celda_right" style="border: 1px solid black; text-align: center; background-color: #DCDCDC;">Efectivo</td>
                    <td class="categoria celda_right" style="border: 1px solid black; text-align: center;"><b> S/. {{number_format($ingresos-$egresos,2)}}</b></td>
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