<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compras</title>
</head>

<body>
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td class="text-end" colspan="15" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px; font-weight: bold;">
                        <h3>Reporte Compras</h3>
                    </td>
                </tr>
                <tr>
                    <td class="text-end" colspan="10" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{ $company->name }}</p>
                    </td>
                    <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong>{{date('Y-m-d')}} </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="10" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}} </p>
                    </td>
                    <td colspan="5" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong> {{$company->number}}</p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        @php
        $acum_total_taxed=0;
        $acum_total_igv=0;
        $acum_total=0;

        $acum_total_taxed_usd=0;
        $acum_total_igv_usd=0;
        $acum_total_usd=0;
        @endphp
        @if(!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">#</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Tipo Doc</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Número</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">F. Emisión</th>
                            <th class="" style="border: 2px solid black; background-color: #DCDCDC;">F. Vencimiento</th>

                            <th style="border: 2px solid black; background-color: #DCDCDC;">Cliente</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">RUC</th>
                            <th class="" style="border: 2px solid black; background-color: #DCDCDC;">F. Pago</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Estado</th>
                            <th class="" style="border: 2px solid black; background-color: #DCDCDC;">T.Exonerado</th>

                            <th class="" style="border: 2px solid black; background-color: #DCDCDC;">T.Inafecta</th>
                            <th class="" style="border: 2px solid black; background-color: #DCDCDC;">T.Gratuito</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Total Gravado</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Total IGV</th>
                            <th style="border: 2px solid black; background-color: #DCDCDC;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $key => $value)
                        <tr>
                            <td class="celda" style="border: 2px solid black;">{{$loop->iteration}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->document_type->id}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->series}}-{{$value->number}}</td>
                            {{-- <td class="celda">{{$value->date_of_issue}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->date_of_due}}</td> --}}
                            <td class="celda" style="border: 2px solid black;"> {{ \Carbon\Carbon::parse($value->date_of_issue)->format('d-m-Y') }}</td>
                            <td class="celda" style="border: 2px solid black;"> {{ \Carbon\Carbon::parse($value->date_of_due)->format('d-m-Y') }}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->supplier->name}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->supplier->number}}</td>
                            <td class="celda" style="border: 2px solid black;">{{isset($value->purchase_payments['payment_method_type']['description'])?$value->purchase_payments['payment_method_type']['description']:'-'}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->state_type->description}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->total_exonerated}}</td>

                            <td class="celda" style="border: 2px solid black;">{{ $value->total_unaffected}}</td>
                            <td class="celda" style="border: 2px solid black;">{{ $value->total_free}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->state_type_id == '11' ? 0 : $value->total_taxed}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->state_type_id == '11' ? 0 : $value->total_igv}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$value->state_type_id == '11' ? 0 : $value->total}}</td>

                            @php
                            $value->total_taxed = (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total_taxed;
                            $value->total_igv = (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total_igv;
                            $value->total = (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total;
                            $state = $value->state_type_id;
                            @endphp
                        </tr>

                        @php

                        if($value->currency_type_id == 'PEN'){

                        if($state == '11'){

                        $acum_total += 0;
                        $acum_total_taxed += 0;
                        $acum_total_igv += 0;


                        }else{

                        $acum_total += $value->total;
                        $acum_total_taxed += $value->total_taxed;
                        $acum_total_igv += $value->total_igv;
                        }

                        }else if($value->currency_type_id == 'USD'){

                        if($state == '11'){

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
                            <td class="celda" colspan="11" ></td>
                            <td class="celda" style="border: 2px solid black;">Totales PEN</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total_taxed}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total_igv}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total}}</td>
                        </tr>
                        <tr>
                            <td class="celda" colspan="11"></td>
                            <td class="celda" style="border: 2px solid black;">Totales USD</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total_taxed_usd}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total_igv_usd}}</td>
                            <td class="celda" style="border: 2px solid black;">{{$acum_total_usd}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </table>
    @else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>