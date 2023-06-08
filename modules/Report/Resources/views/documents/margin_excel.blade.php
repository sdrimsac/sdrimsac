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
            <table width="100%" border="0" style="border-collapse: collapse;border-bottom:1px solid #ddd;">
                <tr>
                  
                    <td height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;"> 
                           @if($month=="Mensual")
                           <p align="center">Reporte Margen de Utilidad  de <strong> {{$d_month_start}} </strong></p>
                           @endif
                           @if($month=="Por Rango de Fecha")
                           <p align="center">Reporte Margen de Utilidad <strong>desde {{ Carbon\Carbon::parse($date_start)->format('d-m-Y') }}  hasta {{ Carbon\Carbon::parse($date_end)->format('d-m-Y') }}</strong></p>
                           @endif
                           @if($month=="Rango de Mes")
                           <p align="center">Reporte Margen de Utilidad <strong>desde {{ Carbon\Carbon::parse($date_start)->format('d-m-Y') }}  hasta {{ Carbon\Carbon::parse($date_end)->format('d-m-Y') }}</strong></p>
                           @endif
                           @if($month=="Por Fecha")
                           <p align="center">Reporte Margen de Utilidad <strong>  de {{ Carbon\Carbon::parse($date_start)->format('d-m-Y') }}</strong></p>
                           @endif
                   
                   </td>
                </tr>
           </table>
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
        @if($typeresult=="Detallado")
       
        <div class="">
            <div class=" ">
             
              
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="celda_center">#</th>
                             <th>ASESOR - VENDEDOR</th>
                             <th class="celda_center">FECHA</th>
                             <th>DOCUMENTO</th>
                             <th>CLIENTE</th>
                             <th class="celda_center">UTILIDAD</th>
                         </tr>
                    </thead>
                    <tbody>
                        @php
                          $acum_total=0
                         @endphp 
                        @foreach($result as  $value)
                        @php
                        $acum_total+=$value['total_margen']
                       @endphp 
                        <tr>
                            <td class="celda_center">{{$loop->iteration}}</td>
                            <td class="celda">{{$value['user_name']}}</td>
                            <td class="celda_center">{{$value['date_of_issue']}}</td>
                            <td class="celda">
                                {{$value['document']}}
                                <b> N° {{$value['number_full']}}</b>
                            </td>
                             <td class="celda">{{$value['customer']}}</td>
                            <td class="celda_center">{{$value['total_margen']}}</td>
                        </tr>
                        @endforeach   
                        <tr>
                            <td colspan="5" class="celda_right"><b>TOTAL UTILIDAD</b></td>
                            <td class="celda_center">S/.{{$acum_total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>                    
        @else
        @if($typeresult=="Resumen")
            
            <div class="">
                <div class=" ">
                    @php
                        $acum_total_taxed=0;
                    @endphp
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Comprobante</th>
                                 <th>Utilidad</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                             
                            <tr>
                                <td class="celda">1</td>
                                <td class="celda">FACTURA - BOLETA DE VENTA</td>
                                <td class="celda">{{$margin_document_total}}</td>
                            </tr>
                            <tr>
                                <td class="celda">2</td>
                                <td class="celda">NOTA DE VENTA</td>
                                <td class="celda">{{$margin_sales_total}}</td>
                            </tr>   
                            <tr>
        
                                <td class="celda celda_right" colspan="2"><b>Total Utilidad</b></td>
                                <td class="celda">{{number_format($margin_document_total+$margin_sales_total,2)}}</td>

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
