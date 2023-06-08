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
            <h3 align="center" class="title"><strong>REPORTE POR CLIENTE</strong></h3>
        </div>
        <br>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                @if(!empty($records))

                    <tr>
                        <td>
                            <p><b>Cliente: </b></p>
                        </td>
                        <td align="center">
                            <p><strong>{{$records[0]->customer_number}} - {{$records[0]->customer_name}}</strong></p>
                        </td>
                    </tr>
                @endif
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
                    <td>
                        <p><strong>Establecimiento: </strong></p>
                    </td>
                    <td align="center">{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</td>
                </tr>
            </table>
        </div>
        <br>
        @if(!empty($records))
        <div class="">
            <div class=" ">
                @php
                    $total_pagados=0;
                    $acum_total_pendient=0;
                    $acum_total=0;
                    $total_advances=0;
                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th class="center">#</th>
                            <th class="center">Fecha Emisión</th>
                            <th class="center">Fecha Pago</th>
                            <th class="">Documento</th>
                            <th class="center">Estado</th>
                            <th class="center">Monto Facturado</th>
                            <th class="center">Adelantos</th>
                            <th class="center">Deuda Pendiente</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($records as $key => $valuess)
                        <tr>
                            <?php
                            if($valuess->document_type_id=="80"){
                                    $sales=App\Models\Tenant\SaleNote::findOrFail($valuess->id);
                                    $payments=App\Models\Tenant\SaleNotePayment::select( Illuminate\Support\Facades\DB::raw('SUM(payment) as total_payment'))->where('sale_note_id',$sales->id)->first();
                                    $deuda_pendiente=$valuess->total - $payments->total_payment;

                            }else{
                                $document=App\Models\Tenant\Document::findOrFail($valuess->id);
                                $payments=App\Models\Tenant\DocumentPayment::select(Illuminate\Support\Facades\DB::raw('SUM(payment) as total_payment'))->where('document_id',$document->id)->first();
                                $deuda_pendiente=$valuess->total - $payments->total_payment;

                            }

                            ?>
                              @if($deuda_pendiente>0)
                              <?php
                              $acum_total_pendient=$acum_total_pendient+$deuda_pendiente;
                              ?>

                          @endif
                            <td class="celda">{{$loop->iteration}}</td>
                            <td class="celda center {{ $deuda_pendiente>0 ? 'text-danger' : '' }}">
                                {{ Carbon\Carbon::parse($valuess->date_of_issue)->format('d-m-Y') }}
                            </td>
                            <td class="celda center">

                                {{ $valuess->date_payment }}  {{ $valuess->hora_pago }}
                            </td>
                             <td class="celda {{ $deuda_pendiente>0 ? 'text-danger' : '' }}">
                                 {{$valuess->document_type_description}}  {{$valuess->series}} - {{$valuess->number}}
                                </td>

                            <td class="celda center {{ $deuda_pendiente>0 ? 'text-danger' : '' }}">
                                @if($deuda_pendiente>0)
                                     PENDIENTE
                                 @else
                                     PAGADO
                                @endif
                            </td>
                            <td class="celda center {{ $deuda_pendiente>0 ? 'text-danger' : '' }}">
                                {{$valuess->total}}
                            </td>
                            <td class="celda center">
                                @if($valuess->advances>0)
                                   {{$valuess->advances}}
                                   <?php
                                        $total_advances=$total_advances+$valuess->advances;
                                   ?>
                                @endif
                            </td>
                            <td class="celda center {{ $deuda_pendiente>0 ? 'text-danger' : '' }}">
                                @if($deuda_pendiente>0)
                                    {{number_format($deuda_pendiente,2)}}
                                @endif
                            </td>

                            @php
                              $signal = $valuess->document_type_id;
                              $state = $valuess->state_type_id;
                            @endphp

                        </tr>
                        @if($valuess->status_payment=='PAGADO')
                        <?php
                        $total_pagados=$total_pagados+$valuess->total;
                        ?>
                        @endif

                        @php
                        $acum_total =$acum_total+$valuess->total;
                        @endphp
                        @endforeach
                        {{-- <tr>
                            <td colspan="6" class="celda"></td>
                            <td  class="celda" align="right"><b>MONTO PAGADO</b></td>
                            <td  class="celda center"><b>{{$total_pagados}}</b></td>


                        </tr> --}}
                        <tr>
                            <td colspan="5" class="celda"></td>
                             <td class="celda right"><b>TOTAL</b></td>
                            <td  class="celda center"><b>{{number_format($total_advances,2)}}</b></td>
                            <td  class="celda center"><b>{{number_format($acum_total_pendient,2)}}</b></td>
                        </tr>

                        {{-- <tr>
                            <td colspan="6" class="celda"></td>
                            <td  class="celda" align="right"><b>TOTAL FACTURADO</b></td>
                            <td  class="celda center"><b>{{$acum_total}}</b></td>
                        </tr> --}}

                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div>
                <p>No se encontraron registros.</p>
            </div>
        @endif
    </body>
</html>
