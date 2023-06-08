<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <style>
            html {
                font-family: sans-serif;
                font-size: 11px;
            }
            .border_header td{
                border-bottom: 0.1px solid #ccc !important;
                padding: 3px !important;;
            }
            .border_header {
                border: 0.1px solid #ccc !important;
              
              
            }
            table {
                width: 98%;
                border-right: 0.1px solid #ccc !important;
                
            }
            .center{
                text-align:center !important;
            

            }
            .right{
                border-right: 0.1px solid #ccc;
            }
            .celda {
                text-align:left;
                padding: 3px;
                border: 0.1px solid #ccc;
            }
            
            th {
                padding: 3px;
                text-align: center;
                border-color: #409EFF;
                border: 0.1px solid #ccc;
            }
            
            .title {
                font-weight: bold;
                padding: 3px;
                font-size: 20px !important;
                text-decoration: underline;
            }
            
            p>strong {
                margin-left: 5px;
                font-size: 13px;
            }
            
            thead {
                font-weight: bold;
                color: #000;
                text-align: center;
            }
            .headers{
                padding:5px !important;
                border-bottom:0.1px solid #ccc;
            }
            @page {
            margin: 0cm 0.5cm 0cm 0.5cm;
            font-family: Arial;
        }
        body {
            margin: 1.5cm 0.5cm 0.5cm 0.5cm;
        }
        </style>
    <body>
    <header>
   <table  style="border-right:0px !important;" width="100%" border="0" style="border-collapse: collapse;border-bottom:1px solid #ddd;">
        <tr>
            <td width="70%" height="30" align="left" valign="top">
            @if($company->logo)
                <img src="{{ asset('storage/uploads/logos/'.$company->logo) }}" width="60" />
            @else
                <img src="{{asset('logo/ 700x300.png')}}" alt="Logo" height="40"/>
            @endif
            </td>
            <td width="30%" height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;">Reporte de Productos Vencidos</td>
        </tr>
   </table>
</header>
        <br>
        <div style="margin-top:5px; margin-bottom:5px;">
            <table style="border-right:0px !important;" cellpadding="0" cellspacing="0">
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
        <br>
        @if(!empty($records))
            @php
                $acum_total_taxed=0;
                $acum_total_igv=0;
                $acum_total=0;
                
                $serie_affec = '';
                $acum_total_exonerado=0;
                $acum_total_inafecto=0;

                $acum_total_free=0;

                $acum_total_taxed_usd = 0;
                $acum_total_igv_usd = 0;
                $acum_total_usd = 0;
                $acum_quantity=0;
                    @endphp
            <div class="">
                <div class=" ">
                 
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">Fecha Vencimiento</th>
                                <th class="">Producto</th>
                                <th class="">Codigo Interno</th>
                                <th class="">Precio de Compra</th>
                                <th class="">Precio de Venta</th>
                                <th class="right">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)
                            <tr>
                                <td class="celda center">{{$loop->iteration}}</td>
                                <td class="celda center">{{ Carbon\Carbon::parse($value->date_of_due)->format('d-m-Y') }}
                    </td> 
                                <td class="celda">{{$value->description}}</td>
                                <td class="celda center">{{$value->internal_id}}</td>
                                <td class="celda center">{{$value->purchase_unit_price}}</td>
                                <td class="celda center">{{$value->sale_unit_price}}</td>
                                <td class="celda center" style="border-right:  border-right: 0.1px solid black;">{{$value->stock}}</td>
                            </tr>
                            @php
 
                                $acum_quantity ++; 

                            @endphp
                            @endforeach
                            <tr>
                                <td class="celda" colspan="5"></td> 
                                <td class="celda center"><b>Total de Productos</b></td>
                                <td class="celda center"><b>{{$acum_quantity}}</b></td>
                                <td></td>
                            </tr> 
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
