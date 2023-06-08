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
              
            }
            .table{
                border: 0.1px solid #ccc;
            }
            .celda {
                text-align: left;
                padding: 5px;
                border: 0.1px solid #ccc;
            }
            .celda_center {
                text-align: center;
                padding: 5px;
                border: 0.1px solid #ccc;
            }
            .celda_right {
                text-align: right;
                padding: 5px;
                border: 0.1px solid #ccc;
             }
            tr:nth-child(even) {
            
            }
            .nth-child {
                background-color: transparent;
            }
            .border-bottom{
                 border-bottom: 0.1px solid #ccc;
            }
            th {
                padding: 5px;
                text-align: center;
                border-color: #409EFF;
                border: 0.1px solid #ccc;
            }
            .headers{
                padding:5px !important;
                border-bottom:0.1px solid #ccc;
                height:25px;
            }
            .title {
                font-weight: bold;
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
                 color:#000;
                text-align: center;
            }
            .title {
                font-weight: bold;
                padding: 3px;
                font-size: 20px !important;
                text-decoration: underline;
            }
            .encabezado{
                background-color:#ccc;
                text-transform: uppercase;
                padding: 5px;
                padding-left: 10px;
            }
            .categoria{
                background-color:#eee;
                text-transform: uppercase;
                padding: 5px;
                padding-left: 50px;
            }
            .celda_loop{
                width:10% !important;
                text-align: center;
                padding: 5px;
                border: 0.1px solid #ccc;
            }
                    .celda_descrip{
                width:60% !important;
                text-align: left;
                padding: 5px;
                border: 0.1px solid #ccc;
            }
            .celda_date{
                width:30% !important;
                text-align: center;
                padding: 5px;
                border: 0.1px solid #ccc;
            }
            .celda_left{
                width:30% !important;
                text-align: left;
                padding: 5px;
                border: 0.1px solid #ccc;
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
        @page {
            margin: 0.5cm 0.5cm 0cm 0.5cm;
            font-family: sans-serif;
        }
       
        td,th{
                font-size:10px !important;
                height:15px;
            }
        body {
            margin: 1.5cm 0.5cm 0.5cm 0.5cm;
        }
        </style>
    </head>
    <body>
    <header>
   <table  style="border-collapse: collapse;border-bottom:1px solid #ddd;">
        <tr>
            <td width="60%" height="30" align="left" valign="top">
            @if($company->logo)
                <img src="{{ asset('storage/uploads/logos/'.$company->logo) }}" height="40" />
            @else
                <img src="{{asset('logo/ 700x300.png')}}" alt="Logo" height="40"/>
            @endif
            </td>
            <td width="40%" height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;">Listado de Clientes</td>
        </tr>
   </table>
</header>
       
        <div>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="headers" height="20">
                       <strong>Empresa: </strong>{{$company->name}}
                    </td>
                    <td class="headers">
                        <strong>Fecha: </strong>{{date('Y-m-d')}}
                    </td>
                </tr>
                <tr class="nth-child">
                    <td class="headers" height="20">
                        <strong>Ruc: </strong>{{$company->number}}
                    </td>
                    <td class="headers">
                        <strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
        @if(!empty($records))
            <div class="">
                <div class=" ">
                     @php
                        $totales_ingresos=0;
                        $totales_egresos=0;
                        $ingresos=0;
                        $egresos=0;
                        $depositos=0;
                        $transferencia=0;
                    @endphp
                    <table>
                        <tbody>
                             <tr>
                                <td class="encabezado">#</td>
                                <td class="encabezado">N° DOCUMENTO</td>   
                                <td class="encabezado">NOMBRE - RAZON SOCIAL</td>   
                                <td class="encabezado">DIRECCION</td>   
                                <td class="encabezado">EMAIL</td>   
                                <td class="encabezado">TELEFONO</td>   

                            </tr>
                        <tbody>
                            @foreach($records as $row)
                            <tr> 
                                <td class="celda_loop">{{$loop->iteration}}</td>  
                                <td class="celda_left">{{$row->number}}</td> 
                                <td class="celda_left">{{$row->name}}</td> 
                                <td class="celda_left">{{$row->address}}</td> 
                                <td class="celda_left">{{$row->email}}</td> 
                                <td class="celda_left">{{$row->telephone}}</td> 
                            </tr>
                        @endforeach

                            
                        </tbody>
                        </table>
                        
                    @else
            <div class="callout callout-info">
                <p>No se encontraron registros.</p>
            </div>
        
        @endif
        <footer>
            <table width="100%" border="0" style="border-collapse: collapse;border-top:1px solid #ddd;">
                <tr>
                    <td align="left" valign="middle" colspan="2">Direccion:{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}} - Telefonos: {{$establishment->telephone}} Email:  {{$establishment->email}}</td>
                </tr>
            </table>
        </footer>
    </body>
    

</html>
