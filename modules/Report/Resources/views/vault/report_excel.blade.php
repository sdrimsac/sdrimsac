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
            <h3 align="center" class="title"><strong>Reporte Documentos</strong></h3>
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
                    $amount=0;
                @endphp
                    <table width="100%" class="">
                        <thead>
                           
                            <tr>
                                <th>#</th>
                                <th>Transferido a</th>
                                <th>Fecha</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        @foreach($records as $row)
                        <?php
                            $amount=$amount+$row['amount']
                        ?>
                            <tr> 
                                <td class="celda_loop">{{$loop->iteration}}</td>  
                                <td class="celda_descrip">{{$row['destination']}}</td> 
                                <td class="celda_date"> {{ \Carbon\Carbon::parse($row['date'])->format('d-m-Y') }}</td> 
                                <td class="celda_date">{{$row['amount']}}</td> 
                            </tr>
                        @endforeach
                            <tr> 
                                <td class="celda_right" colspan="3">Total S/.</td> 
                                <td class="celda_date"><b>{{$amount}}</b></td> 
                            </tr>
                        </table>
                 
                @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    
    @endif
    </body>
</html>
