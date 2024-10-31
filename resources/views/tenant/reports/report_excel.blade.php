<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<!-- reporte de documento de boletas y facturas -->

<body>
    <table>
        <tr>
            <td colspan="17" style="border: 1px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                <h3 align="center" class="title"><strong>Reporte Documentos Boletas y Facturas</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="10" style=" border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Empresa:</strong>{{$company->name}}</p>
            </td>
            <td colspan="7" style=" border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Fecha: </strong>{{date('Y-m-d')}}</p>
            </td>
        </tr>
        <tr>
            <td colspan="10" style=" border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}} </p>
            </td>
            <td colspan="7" style=" border: 1px solid black; background-color: #DCDCDC; font-size: 12px;">
                <p><strong>Ruc: </strong>{{$company->number}}</p>
            </td>
        </tr>


        @if(!empty($records))


        @php
        $acum_total_taxed=0;
        $acum_total_igv=0;
        $acum_total=0;

        $serie_affec = '';
        $acum_total_exonerado=0;
        $acum_total_inafecto=0;
        $acum_total_remain = 0;
        $acum_total_remain_usd = 0;
        $acum_total_free=0;

        $acum_total_taxed_usd = 0;
        $acum_total_igv_usd = 0;
        $acum_total_usd = 0;
        @endphp

        <thead>
            <tr>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">#</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Tipo Doc</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Número</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Fecha emisión</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Doc. Afectado</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Cliente</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">RUC</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Estado</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Moneda</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total Exonerado</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total Inafecto</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total Gratuito</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total Gravado</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total IGV</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Saldo</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Condicon de Pago</th>
                <th style=" border: 1px solid black; background-color: #DCDCDC;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $key => $value)
            <tr>
                <td class="celda" style=" border: 1px solid black;">{{$loop->iteration}}</td>
                <td class="celda" style=" border: 1px solid black;">{{$value->document_type->id}}</td>
                <td class="celda" style=" border: 1px solid black;">{{$value->series}}-{{$value->number}}</td>
                <td class="celda" style=" border: 1px solid black;">{{$value->date_of_issue}}</td>
                @if(in_array($value->document_type_id,["07","08"]) && $value->note)

                @php
                $serie = ($value->note->affected_document) ? $value->note->affected_document->series : $value->note->data_affected_document->series;
                $number = ($value->note->affected_document) ? $value->note->affected_document->number : $value->note->data_affected_document->number;
                $serie_affec = $serie.' - '.$number;

                @endphp


                @endif
                <td class="celda" style=" border: 1px solid black;">{{$serie_affec }} </td>
                <td class="celda" style=" border: 1px solid black;">{{$value->customer->name}}</td>
                <td class="celda" style=" border: 1px solid black;">{{$value->customer->number}}</td>
                <td class="celda" style=" border: 1px solid black;">{{$value->state_type->description}}</td>

                @php
                $signal = $value->document_type_id;
                $state = $value->state_type_id;
                @endphp

                <td class="celda" style=" border: 1px solid black;">{{$value->currency_type_id}}</td>



                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total_exonerated}} </td>
                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total_unaffected}}</td>
                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total_free}}</td>

                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total_taxed}}</td>

                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total_igv}}</td>
                @php
                $remain = "";
                if($value->payment_condition_id == "02"){
                $boxes = \App\Models\Tenant\Box::where('document_id',$value->id)->sum('amount');
                $remain = $value->total - $boxes;
                $acum_total_remain += $remain;
                }
                @endphp
                <td class="celda" style=" border: 1px solid black;">{{$remain}}</td>
                <td class="celda" style=" border: 1px solid black;">{{ $value->payment_condition->name }}</td>
                <td class="celda" style=" border: 1px solid black;">{{($signal == '07' || ($signal!='07' && ($state=='11' || $state == '09'))) ? "-" : ""  }}{{$value->total}}</td>
                @php

                $serie_affec = '';

                @endphp

            </tr>
            @php
            if($value->currency_type_id == 'PEN'){
            /*$acum_total_taxed += $signal != '07' ? $value->total_taxed : -$value->total_taxed ;
            $acum_total_igv += $signal != '07' ? $value->total_igv : -$value->total_igv ;
            $acum_total += $signal != '07' ? $value->total : -$value->total ;*/

            /*$acum_total_exonerado += $signal != '07' ? $value->total_exonerated : -$value->total_exonerated ;
            $acum_total_inafecto += $signal != '07' ? $value->total_unaffected : -$value->total_unaffected ;
            $acum_total_free += $signal != '07' ? $value->total_free : -$value->total_free ;*/


            if(($signal == '07' && ($state !== '11' && $state !== '09'))){

            $acum_total += -$value->total;
            $acum_total_taxed += -$value->total_taxed;
            $acum_total_igv += -$value->total_igv;


            $acum_total_exonerado += -$value->total_exonerated;
            $acum_total_inafecto += -$value->total_unaffected;
            $acum_total_free += -$value->total_free;


            }elseif($signal != '07' && ($state == '11' || $state == '09')){

            $acum_total += 0;
            $acum_total_taxed += 0;
            $acum_total_igv += 0;

            $acum_total_exonerado += 0;
            $acum_total_inafecto += 0;
            $acum_total_free += 0;

            }else{

            $acum_total += $value->total;
            $acum_total_taxed += $value->total_taxed;
            $acum_total_igv += $value->total_igv;

            $acum_total_exonerado += $value->total_exonerated;
            $acum_total_inafecto += $value->total_unaffected;
            $acum_total_free += $value->total_free;
            }


            }else if($value->currency_type_id == 'USD'){

            if(($signal == '07' && ($state !== '11' && $state !== '09'))){

            $acum_total_usd += -$value->total;
            $acum_total_taxed_usd += -$value->total_taxed;
            $acum_total_igv_usd += -$value->total_igv;



            }elseif($signal != '07' && ($state == '11' || $state == '09')){

            $acum_total_usd += 0;
            $acum_total_taxed_usd += 0;
            $acum_total_igv_usd += 0;


            }else{

            $acum_total_usd += $value->total;
            $acum_total_taxed_usd += $value->total_taxed;
            $acum_total_igv_usd += $value->total_igv;

            }


            }
            @endphp
            @endforeach
            <tr>
                <td colspan="8"></td>
                <!-- <td >Totales</td>
                                <td>{{$acum_total_exonerado}}</td>
                                <td>{{$acum_total_inafecto}}</td>
                                <td>{{$acum_total_free}}</td> -->
                <td style=" border: 1px solid black; background-color: #DCDCDC;">Totales PEN</td>

                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{number_format($acum_total_exonerado, 2)}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{number_format ($acum_total_inafecto, 2 )}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{number_format($acum_total_free, 2)}}</td>

                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total_taxed}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total_igv}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">
                    {{$acum_total_remain}}
                </td>
                <td></td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total}}</td>
            </tr>
            <tr>
                <td colspan="8"></td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">Totales USD</td>
                <td></td>
                <td></td>
                <td></td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total_taxed_usd}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total_igv_usd}}</td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">
                    {{$acum_total_remain_usd}}
                </td>
                <td></td>
                <td style=" border: 1px solid black; background-color: #DCDCDC;">{{$acum_total_usd}}</td>
            </tr>
        </tbody>
    </table>
    @else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>