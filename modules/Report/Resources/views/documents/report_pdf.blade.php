<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            html {
                font-family: sans-serif;
                font-size: 12px;
            }
            
            table {
                width: 100%;
                border-spacing: 0;
                border: 1px solid #ddd;
            }
            
            .celda {
                text-align: center;
                padding: 5px;
                border: 0.1px solid #ddd;
            }
            .celda2 {
                text-align: left;
                padding: 5px;
                border: 0.1px solid #ddd;
            }
            .celda3 {
                text-align: right;
                padding: 5px;
                border: 0.1px solid #ddd;
            }
            th {
                padding: 5px;
                text-align: center;
                border-color: #ddd;
                border: 0.1px solid #ddd;
            }
            
            .title {
              
                padding: 5px;
                font-size: 20px !important;
                text-decoration: underline;
            }
            
            p>strong {
                margin-left: 5px;
                font-size: 13px;
            }
            
            thead {
                font-weight: bold;
                background: #eee;
                color: #000;
                text-align: left !important;
            }
        </style>
    </head>
    <body>
        <div>
            @if($status=="01")
            <p align="center" class="title">Reporte Ventas Realizadas <strong>Desde:{{$date_start}}  Hasta:{{$date_end}}</strong></p>
            @else
            <p align="center" class="title">Reporte Ventas Resumen <strong>Desde:{{$date_start}}  Hasta:{{$date_end}}</strong></p>
            @endif
        </div>
        <div style="margin-top:20px; margin-bottom:20px;">
            <table>
                <tr>
                    <td>
                        <p><strong>Empresa: </strong>{{$company->name}}</p>
                    </td>
                    <td>
                        <p><strong>Fecha: </strong>{{date('Y-m-d')}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Ruc: </strong>{{$company->number}}</p>
                    </td>
                    <td>
                        <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</p>
                    </td>
                   
                </tr>
               
            </table>
        </div>
       
        @if($status=="02")
       
        <div class="">
            <div class=" ">
             
                <table>
                    <thead>
                        <tr>
                             <th colspan="3" style="float:left !important">NOTA DE VENTA</th>
                         </tr>
                        <tr>
                            <th>#</th>
                            <th>Vendedor</th>
                             <th style="text-align: center !important">Total de Venta</th>
                            
                         </tr>

                    </thead>
                    <tbody>
                        @php                            
                        $acum_total=0;                      
                        @endphp
                        @foreach($resumen_sale_notes_result as  $value)
                        <tr>
                            <td class="celda">{{$loop->iteration}}</td>
                            <td class="celda2">{{$value['name']}}</td>
                            <td class="celda">{{$value['total']}}</td>
                          @php
                           $acum_total += $value['total'];
                          @endphp
                           </tr>
                            @endforeach   
                       
                        <tr>
                            <td></td>
                            <td align="right">Total S/.</td>
                             <td align="center">{{number_format($acum_total,2)}}</td>   
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                             <th colspan="3">FACTURA - BOLETA</th>
                         </tr>
                        <tr>
                            <th>#</th>
                            <th>Vendedor</th>
                             <th style="text-align: center !important">Total de Venta</th>
                            
                         </tr>

                    </thead>
                    <tbody>
                        @php                            
                        $acum_total2=0;  


                        @endphp
                        @foreach($resumen_documents_result as  $value)
                        <tr>
                            <td class="celda">{{$loop->iteration}}</td>
                            <td class="celda2">{{$value['name']}}</td>
                            <td class="celda">{{$value['total']}}</td>
                          @php
                           $acum_total2 += $value['total'];
                          @endphp
                           </tr>
                            @endforeach   
                            <tr>
                                <td colspan="3" height="20"><hr style="border:1px solid #eee;"></td>
                               
                            </tr>
                        <tr>
                            <td></td>
                            <td align="right">Total S/.</td>
                             <td align="center">{{number_format($acum_total2,2)}}</td>   
                        </tr>
                        <tr>
                            <td class="celda"></td>
                            <td class="celda3" >Total Nota de Venta</td>
                            <td class="celda">{{$acum_total}}</td>
                        </tr>
                        <tr>
                            <td class="celda"></td>
                            <td class="celda3" >Total Factura</td>
                            <td class="celda">{{$acum_total2}}</td>
                        </tr>
                        <tr>
                            <td class="celda"></td>
                            <td class="celda3">Total</td>
                            <td class="celda">{{number_format($acum_total+$acum_total2,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>                    
        @else
        @if($status=="01")
            
            <div class="">
                <div class=" ">
                    @php
                        $acum_total_taxed=0;
                        $acum_total_igv=0;
                        $acum_total=0;
                     
                        $serie_affec = '';

                        $acum_total_exonerado=0;
                        $acum_total_inafecto=0;

                        $acum_total_free=0;
                        $acum_total_free_usd=0;
                        $acum_total_exonerado_usd=0;
                        $acum_total_inafecto_usd=0;
                        $acum_total_taxed_usd=0;
                        $acum_total_igv_usd=0;
                        $acum_total_usd=0;
                    @endphp
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendedor</th>
                                 <th>Comprobante</th>
                                <th>Número</th>
                                 <th>Fecha emisión</th>
                                <th>Cliente</th>
                                <th>RUC</th>
                                <th  class="celda">Subtotal</th>
                                <th class="celda">Igv</th>
                                <th  class="celda">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $key => $value)
                             
                            <tr>
                                <td class="celda">{{$loop->iteration}}</td>
                                <td class="celda">{{$value->name}}</td>
                                @if($value->document_type_id=="01")
                                <td class="celda">FACTURA</td>
                                @endif
                                @if($value->document_type_id=="03")
                                <td class="celda">BOLETA DE VENTA</td>
                                @endif 
                                @if($value->document_type_id=="80")
                                <td class="celda">NOTA DE VENTA</td>
                                @endif 
                                <td class="celda">{{$value->series}} {{$value->number}}</td>
                                
                                <td class="celda">{{$value->date_of_issue}}</td>
                                <td class="celda">{{json_decode($value->customer)->name}}</td>
                                <td class="celda">{{json_decode($value->customer)->number}}</td>
                                @php
                                $signal = $value->document_type_id;
                                $state = $value->state_type_id;
                               @endphp
                                @if($signal == '07')                                    

                                <td class="celda">{{$signal == '07' ? "-" : ""  }}{{$value->total_taxed}}</td>
                                <td class="celda">{{$signal == '07' ? "-" : ""  }}{{$value->total_igv}}</td>
                                <td class="celda">{{$signal == '07' ? "-" : ""  }}{{$value->total}}</td>
                    
                            @else
                                <td class="celda">{{ (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total_taxed}}</td>                                      
                                <td class="celda">{{ (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total_igv}}</td>
                                <td class="celda">{{ (in_array($value->document_type_id,['01','03']) && in_array($value->state_type_id,['09','11'])) ? 0 : $value->total}}</td>
                    
                            @endif
                               @php
    
                               if($value->currency_type_id == 'PEN'){
                                   
                                   /*$acum_total_taxed +=  $signal != '07' ? $value->total_taxed : -$value->total_taxed ;
                                   $acum_total_igv +=  $signal != '07' ? $value->total_igv : -$value->total_igv ;
                                   $acum_total += $signal != '07' ? $value->total : -$value->total ;*/
                                     $acum_total += $value->total;
                                     $acum_total_taxed += $value->total_taxed;
                                       $acum_total_igv += $value->total_igv;
                               }else if($value->currency_type_id == 'USD'){
                                      $acum_total_usd += $value->total;
                                       $acum_total_taxed_usd += $value->total_taxed;
                                       $acum_total_igv_usd += $value->total_igv;
                       
                               }
                           @endphp
                            @endforeach
                            <tr>
                                <td class="celda" colspan="6"></td>
                                <td class="celda" >Totales PEN</td>
                                <td class="celda">{{$acum_total_taxed}}</td>
                                <td class="celda">{{$acum_total_igv}}</td>
                                <td class="celda">{{$acum_total}}</td>

                            </tr>
                            <tr>
                                <td class="celda" colspan="6"></td>
                                <td class="celda" >Totales USD</td>
                                <td class="celda">{{$acum_total_taxed_usd}}</td>
                                <td class="celda">{{$acum_total_taxed_usd}}</td>
                                <td class="celda">{{$acum_total_usd}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="callout callout-info">
                <p>No se encontraron registros.</p>
            </div>
        @endif
        @endif 
    </body>
</html>
