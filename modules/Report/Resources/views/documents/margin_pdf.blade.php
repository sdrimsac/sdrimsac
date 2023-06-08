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
            
            .headers{
                padding:5px !important;
                border-bottom:0.1px solid #ccc;
            }
            .celda,.celda_center,.celda_left,.celda_right {
                padding: 5px;
                border: 0.1px solid #ccc;
                font-size:11px;
            }

            .celda_center{
                text-align: center;
            }
            .celda_left{
                text-align: left;
            }
            .celda_right{
                text-align: right;
            }
            .title {
                font-weight: bold;
                padding: 3px;
                font-size: 20px !important;
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
        thead tr th{
            background-color: #ddd;
            text-align: left;
            padding: 5px;
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
                         <img src="{{ asset('storage/uploads/logos/'.$company->logo) }}" height="50" />
                     @else
                         <img src="{{asset('logo/ 700x300.png')}}" alt="Logo" height="40"/>
                     @endif
                     </td>
                     <td width="40%" height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;"> 
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
                            @else
                            <p align="center">Reporte Margen de Utilidad <strong>  de {{$mes_consultar}}</strong></p>
                            @endif

                    
                    </td>
                 </tr>
            </table>
         </header>
                
                 <div style="margin-top:5px; margin-bottom:5px;">
                     <table cellpadding="0" cellspacing="0">
                         <tr>
                             <td class="headers">
                                <strong>Empresa: </strong>{{$company->name}}
                             </td>
                             <td class="headers">
                                 <strong>Fecha: </strong>{{date('Y-m-d')}}
                             </td>
                         </tr>
                         <tr>
                             <td class="headers">
                                 <strong>Ruc: </strong>{{$company->number}}
                             </td>
                             <td class="headers">
                                 <strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}
                             </td>
                         </tr>
                     </table>
                 </div>

 
       
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
                        <?php
                             $acum_total=$acum_total+$value['total_margen'];
                         ?> 
                        <tr>
                            <td class="celda_center">{{$loop->iteration}}</td>
                            <td class="celda">{{$value['user_name']}}</td>
                            <td class="celda_center">{{$value['date_of_issue']}}</td>
                            <td class="celda">
                                {{$value['document']}}
                                <b> N° {{$value['number_full']}}</b>
                            </td>
                             <td class="celda">{{$value['customer']}}</td>
                            <td class="celda_center">{{number_format($value['total_margen'],2)}}</td>
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
