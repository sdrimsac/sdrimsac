<?php

function format_unit($row,$uit){
    $max_quantity_item = $row["max_quantity_item"];
    $unit_type = $row["unit_type"];
    $unit_item = $row["unit_item"];
    $count = $uit["count"]*$uit["factor"];
    $full = intdiv($count,$max_quantity_item);
    $rest = $count %$max_quantity_item;
    echo "(".number_format($uit["count"],2).")"." ".($full==0?"":$full." ".$unit_item)." ".($rest==0?"":$rest." ".$unit_type);
}
?>
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
                border: 1px solid black;
            }
            
            .celda {
                text-align: center;
                padding: 2px;
                border: 0.1px solid black;
            }
            
            .th {
                padding: 2px;
                text-align: center;
                border-color: #c4c4c4;
                border: 0.1px solid black;
            }
            
            .title {
                font-weight: bold;
                padding: 5px;
                font-size: 20px !important;
                text-decoration: underline;
            }
            .small2{
                font-size: 8px;
            }
            p>strong {
                margin-left: 5px;
                font-size: 13px;
            }
            
            .thead {
                font-weight: bold;
                background: #c4c4c4;
                color: black;
                text-align: center;
            }
        </style>
    </head>
    <body>
        @php
            $gain_total=0;
        @endphp
     
        <div style="margin-top:20px; margin-bottom:20px;">
            <table>
                <tr>
                    <td colspan="6">
                        <p><strong>Reporte de Ganancias</strong></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <p><strong>Empresa: </strong>{{$company->name}}</p>
                    </td>
                    <td>
                        <p><strong>Fechas: </strong>{{
$date_start

                        }}
                    @if ($date_end)
                        - {{$date_end}}
                    @endif    
                    </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p><strong>Ruc: </strong>{{$company->number}}</p>
                    </td>
                  @if ($establishment)
                  <td colspan="5">
                    <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</p>
                </td>
                @else
                <td colspan="3"></td>
                  @endif
                </tr>
            </table>
        </div>
        @if(!empty($items))
            <div class="">
                <div class=" ">
               
                    <table class="">
                        <thead class="thead">
                            <tr>
                                <th class="th">#</th>
                                <th class="th">Producto</th>
                                <th class="th">Cant. Total</th>
                                <th class="th">P.C.</th>
                                <th class="th">P.V.</th>
                                <th class="th">Total</th>
                                <th class="th">Utilidad</th> 
                            </tr>
                        </thead>
                        @php
                            $index = 1;
                        @endphp
                        <tbody>
                            @foreach($items as  $value)
                                @foreach ( $value["prices"] as $price=>$count )
                                <tr>
                                    <td class="celda">{{$index}}</td>
                                    
                                    <td class="celda" style="text-align: left;">{{$value["description"]}}
                                        @if (isset($count["unit_type_name"]))
                                        <span class="small2">({{$count["unit_type_name"]}})</span>
                                    @endif
                                    </td>
                                    <td class="celda">
                                        @if (isset($value["max_quantity_item"]))
                                        {{format_unit($value,$count)}}
                                        @else
                                        @php
                                            $c = floatval($count["count"]) *(isset($count["factor"])?$count["factor"]:1);
                                        @endphp
                                            {{number_format($c,2)}} {{$value["unit_item"]}}
                                        @endif
                                    </td>
                                    <td class="celda">{{number_format($value["purchase_unit_price"],2)}}</td>
                                    <td class="celda">
                                        {{number_format($price,2)}}
                                        
                                    </td>
                                    <td class="celda">{{number_format($count["count"]*$price,2)}}</td>
                                    <td class="celda">
                                        @php
                                        $purchase = floatval($count["count"]) *(isset($count["factor"])?$count["factor"]:1)  * floatval($value["purchase_unit_price"]) ;
                                        $gain = floatval($count["count"]*$price) - $purchase;
                                        $gain_total +=$gain; 
                                       @endphp
                                        
                                        {{number_format($gain,2)}}</td>
                                </tr>
                                @php
                                    $index++;
                                @endphp
                                @endforeach    
                            @endforeach
                           
                            <tr>
                                <td class="celda" colspan="4"></td>
                                <td class="celda" >Totales</td>
                                <td class="celda" >{{number_format($total,2)}}</td>
                                <td class="celda" >{{number_format($gain_total,2)}}</td>
                              
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
    </body>
</html>
