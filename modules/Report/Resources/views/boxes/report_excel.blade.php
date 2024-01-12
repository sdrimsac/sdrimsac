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
        <div>
            <h3 align="center" class="title"><strong>Reporte Documentos</strong></h3>
        </div>
        <br>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td>
                        <p><b>Empresa: </b></p>
                    </td>
                    <td align="center">
                        <p><strong>{{$company->name}}</strong></p>
                    </td>
                    <td>
                        <p><strong>Fecha: </strong></p>
                    </td>
                    <td align="center">
                        <p><strong>{{date('Y-m-d')}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Ruc: </strong></p>
                    </td>
                    <td align="center">{{$company->number}}</td>
                </tr>
            </table>
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
                <table width="100%" class="">
                        {{-- <tr>
                            <td class="encabezado">#</td>
                            <td class="encabezado">Fecha</td>
                            <td class="encabezado">Operacion</td>
                             <td class="encabezado">Concepto</td>
                            <td class="encabezado">Monto</td>
                            <td class="encabezado">Usuario</td> --}}
                         <tr>
                            <td class="encabezado">#</td>
                            <td class="encabezado">Fecha</td>
                            <td class="encabezado">Operacion</td>
                            <td class="encabezado" width="30">Ref</td>
                            <td class="encabezado">Cliente</td>
                            <td class="encabezado">Concepto</td>
                            <td class="encabezado">Monto</td>
                            <td class="encabezado">Usuario</td>
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
                        $date = \Carbon\Carbon::parse($row['date'])->format('d-m-Y')." ".\Carbon\Carbon::parse($row['created_at'])->format('h:m:s');
                        
                        if(isset($row["document_id"]) && $row["document_id"]!=null){
                            $document = \App\Models\Tenant\Document::find($row["document_id"]);
                            $date = $document->date_of_issue." ".$document->time_of_issue;
                        }
                        if(isset($row["sale_note_id"]) && $row["sale_note_id"]!=null){
                            $document = \App\Models\Tenant\SaleNote::find($row["sale_note_id"]);
                            $date = $document->date_of_issue->format('Y-m-d')." ".$document->time_of_issue;
                        }
                        ?>
                        <tr>
                            <td class="celda_loop">{{ $loop->iteration }}</td>
                            <td class="celda_descrip">
                                {{$date}}
                            </td>
                      
                         
                            @if ($row['type'] == '1' && $row['method'])
                                <td class="celda_left">{{$row['method']}}</td>
                            @endif
                           
                            @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                    <td class="celda_left">
                                       {{$row['method']}}
                                    </td>
                            @endif
                                <td class="celda_left">{{$row["cash"]["reference_number"]}}</td>
                            @if ($row['type'] == '2' && $row['method'] == 'Efectivo')
                                <td class="celda_left">
                                    {{ $row['subcategories']->subcategory }}
                                </td>
                            @else
                                @if ($row['type'] == '1' && $row['sale_note_id'] == null && $row['document_id'] == null)
                                    <td class="celda_left">
                                        {{ $row['subcategories']->subcategory }}
                                    </td>
                                @else
                                    @if ($row['sale_note_id'] != null && $row['document_id'] == null)
                                        <td class="celda_left">
                                            {{ $row['salenote']['customer']->name }}
                                        </td>
                                    @else
                                        @if ($row['sale_note_id'] != null && $row['document_id'] != null)
                                            <td class="celda_left">
                                                {{ $row['salenote']['customer']->name }}
                                            </td>
                                        @else
                                            @if ($row['document_id'] != null && $row['sale_note_id'] == null)
                                                <td class="celda_left">
                                                    {{ $row['document']['customer']->name }}
                                                </td>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                            <td class="celda_left">{{ $row['description'] }}</td>
                            <td class="celda_date">{{ $row['amount'] }}</td>
                            <td class="celda_left">{{ $row['user']->name }}</td>

                        </tr>
                    @endforeach

                    </tbody>
                    </table>
                    <table>
                            <tr>
                               <td colspan="6" class="categoria celda_right"></td>
                               <td  class="categoria celda_right"><b>RESUMEN DE ARQUEO</b></td>
                           </tr>
                           <tr>
                               <td colspan="6" class="categoria celda_right">Ingresos - Venta : </td>
                               <td class="categoria celda_right"><b> S/. {{$ingresos}}</b></td>
                           </tr>
                           <tr>
                              
                                <td colspan="6" class="categoria celda_right">Egresos - Gastos : </td>
                                <td class="categoria celda_right"><b> S/. {{$egresos}}</b></td>
                           </tr>

                           @if($type_box=="2" && $type_box!=null)
                           <tr>
                               <td class="categoria celda_right">Gastos - Egresos : <b> S/. {{$egresos}}</b></td>
                           </tr>
                           @endif

                           @if($depositos>0.00 || $transferencia>00)
                           <tr>
                               <td class="categoria celda_right">Depositos - Transferencia : <b> S/. {{number_format($depositos+$transferencia,2)}}</b></td>
                           </tr>
                           @endif

                           @if($type_box=="1" && $type_box!=null)
                           <tr>
                               <td class="categoria celda_right">Totales : <b> S/. {{number_format(($ingresos-$egresos)+$depositos+$transferencia,2)}}</b></td>
                           </tr>
                           @endif

                           @if($type_box=="2" && $type_box!=null)
                           <tr>
                               <td class="categor1ia celda_right">Efectivo  Gastos: <b> S/. {{$egresos}}</b></td>
                               
                           </tr>
                           @endif

                           @if($type_box=="1" && $type_box!=null)
                           <tr>
                               <td colspan="6" class="categoria celda_right">Efectivo</td>
                               <td class="categoria celda_right"><b> S/. {{number_format($ingresos-$egresos,2)}}</b></td>
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
