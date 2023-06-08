<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            html {
                font-family: sans-serif;
                font-size: 11px;
            }
            table {
                width: 100%;
                border-spacing: 0;
                 font-size: 10px;
            }
            td,th{
                font-size:10px !important;
            }
            .center{
                text-align: center !important;
            }
            thead th{
                font-size:10px !important;
                background-color: #ccc;
                padding: 5px;
            }
            .headers{
                padding:5px !important;
                border-bottom:0.1px solid #ccc;
            }
            .celda {
                text-align: left;
                padding: 5px;
                border: 0.1px solid #ccc;
                font-size:11px;
            }
            .title {
                font-weight: bold;
                padding: 3px;
                font-size: 15px !important;
                text-decoration: underline;
            }
            p>strong {
                margin-left: 5px;
                font-size: 11px;
            }
            header {
            position: fixed;
            height: 1cm;
            color: #000;
            text-align: center;
            padding:10px;
            font-size:12px;
            font-family:arial;
           margin-bottom:20px;
        }
        .right{
            text-align: right;
        }
        .text-danger{
            color: red;
        }
        footer {
            position: fixed;
            bottom: 10px;
            height: 0.8cm;
            color:#000;
            text-align: center;
            font-size:11px;
            padding:12px;
            font-family:Arial;
            padding:10px;
        }
        @page {
            margin: 0.5cm 0.5cm 0cm 0.5cm;
            font-family: sans-serif;
        }

        body {
            margin: 1.5cm 0.5cm 0.5cm 0.5cm;
        }
    </style>
    </head>
    <body>
        <header>
            <table width="100%" border="0" style="border-collapse: collapse;border-bottom:1px solid #ddd;">
                 <tr>
                     <td width="60%" height="30" align="left" valign="top">
                     @if($company->logo)
                         <img src="{{ asset('storage/uploads/logos/'.$company->logo) }}" height="30" />
                     @else
                         <img src="{{asset('logo/ 700x300.png')}}" alt="Logo" height="40"/>
                     @endif
                     </td>
                     <td width="55%" height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;">
                        <h3 align="center"><strong>REPORTE DE ESTADO DE CUENTA</strong>
                                                   DESDE {{$date_start}} HASTA  {{$date_end}}
                        </h3>

                    </td>
                 </tr>
            </table>
         </header>
        <br>
        <div>
            <table  >
                @if(!empty($data_pendiente))
                    <tr>
                        <td class="celda">
                            <b>Cliente: </b>
                        </td>
                        <td  class="celda" align="left" colspan="3">
                            <p><strong>{{$data_pendiente[0]->customer_number}} - {{$data_pendiente[0]->customer_name}}</strong></p>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td  class="celda">
                        <b>Empresa: </b>
                    </td>
                    <td  class="celda" align="center" >
                       <strong>{{$company->name}}</strong>
                    </td>
                    <td  class="celda">
                        <strong>Fecha: </strong>
                    </td>
                    <td align="center"  class="celda">
                        <strong>{{date('d-m-Y')}}</strong>
                    </td>
                </tr>
                <tr>
                    <td  class="celda">
                        <p><strong>Ruc: </strong></p>
                    </td>
                    <td  class="celda" align="left" >{{$company->number}}</td>
                    <td  class="celda">
                        <strong>Establecimiento: </strong>
                    </td>
                    <td  class="celda" align="left">{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</td>
                </tr>
            </table>
        </div>
        <br>
        @if(!empty($data_pendiente))
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

                            <?php
                               //dd($data_pendiente);
                            ?>
                            @foreach($data_pendiente as $key => $valuess)
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
