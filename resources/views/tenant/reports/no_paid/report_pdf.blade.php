<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reporte</title>
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
                     <td width="70%" height="30" align="left" valign="top">
                     @if($companies->logo)
                         <img src="{{ asset('storage/uploads/logos/'.$companies->logo) }}" height="40" />
                     @else
                         <img src="{{asset('logo/ 700x300.png')}}" alt="Logo" height="40"/>
                     @endif
                     </td>
                     <td width="30%" height="30" align="right" valign="middle" style="font-size:13px !important;  font-family: sans-serif !important;">Reporte de Cuentas por Cobrar {{$date_start}} hasta {{$date_end}}</td>
                 </tr>
            </table>
         </header>
            <br>
        <br>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td>
                        <p><b>Empresa: </b></p>
                    </td>
                    <td align="center">
                        <p><strong>{{$companies->name}}</strong></p>
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
                    <td align="center">{{$companies->number}}</td>

                </tr>
            </table>
        </div>
        <br>
        @if(!empty($records))
            <div class="">
                <div class=" ">
                    <table class="">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Fecha Emisión</th>
                                <th>Número</th>
                                <th>Cliente</th>
                                <th>Por cobrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)

                                    <tr>
                                        <td class="celda">{{$loop->iteration}}</td>
                                        <td class="celda">{{$value['date_of_issue']}}</td>
                                        <td class="celda">{{$value['number_full']}}</td>

                                        <td class="celda">{{$value['customer_name']}}</td>
                                         <td class="celda">{{$value['total']}}</td>
                                    </tr>

                            @endforeach
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
