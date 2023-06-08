<?php

function format_unit($row){
    $max_quantity_item = $row["max_quantity_item"];
    $unit_type = $row["unit_type"];
    $unit_item = $row["unit_item"];
    $count = $row["count"];
    $full = intdiv($count,$max_quantity_item);
    $rest = $count %$max_quantity_item;
    echo $full." ".$unit_item." ".$rest." ".$unit_type;
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
        <div>
            <p align="center" class="title"><strong>Reporte de Ganancias</strong></p>
        </div>
        <div style="margin-top:20px; margin-bottom:20px;">
            <table>
                <tr>
                    <td>
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
                    <td>
                        <p><strong>Ruc: </strong>{{$company->number}}</p>
                    </td>
                  @if ($establishment)
                  <td>
                    <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</p>
                </td>
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
                        <tbody>
                            @foreach($items as  $value)
                                <tr>
                                    <td class="celda">{{$loop->iteration}}</td>
                                    <td class="celda" style="text-align: left;">{{$value["description"]}}
                                    @if (count($value["prices"])>1)
                                        <table style="border:0px">

                                            <thead>
                                                <tr>
                                                    <th style="text-align: left">Cant.</th>
                                                    <th style="text-align: left">Prec.</th>
                                                    <th style="text-align: left">Ven</th>
                                                    <th style="text-align: left">Uti.</th>
                                                </tr>
                                            </thead>
                                           @foreach ($value["prices"] as $price=>$count )
                                               <tr>
                                               
                                                <td style="text-align: left">
                                                    <small>
                                                        {{number_format($count["count"],2)}}
                                                        @if (isset($count["unit_type_name"]))
                                                            <span class="small2">({{$count["unit_type_name"]}})</span>
                                                        @endif
                                                    </small>
                                                </td>
                                              
                                                <td style="text-align: left">  <small>
                                                    {{number_format($price,2)}}
                                                </small></td>
                                                <td style="text-align: left">  <small>
                                                    {{number_format($price*$count["count"],2)}}
                                                </small></td>
                                                <td>
                                                    
                                                    @php

                                                        $total_count_price = $count["count"] * $price;
                                                        if(isset($count["factor"])){

                                                            $purchase =  $value["purchase_unit_price"] * $count["count"] * $count["factor"];
                                                        }else{

                                                            $purchase =  $value["purchase_unit_price"] * $count["count"];
                                                        }
                                                        $gain=$total_count_price - $purchase;
                                                    @endphp
                                                    <small>
                                                    {{number_format($gain,2)}}
                                                </small></td>
                                               </tr>
                                           @endforeach
                                        </table>
                                    @endif
                                    </td>
                                    <td class="celda">
                                        @if (isset($value["max_quantity_item"]))

                                        {{format_unit($value)}}
                                        @else
                                            {{number_format($value["count"],2)}} {{$value["unit_item"]}}
                                        @endif
                                        
                                    
                                    </td>
                                    <td class="celda">{{number_format($value["purchase_unit_price"],2)}}</td>
                                    <td class="celda">
                                        @if (count($value["prices"])==1)
                                        {{number_format(array_key_first($value["prices"]),2)}}
                                        @endif
                                        
                                    </td>
                                    <td class="celda">{{number_format($value["total"],2)}}</td>
                                    <td class="celda">
                                        @php
                                        $purchase = floatval($value["count"])  * floatval($value["purchase_unit_price"]) ;
                                        $gain = floatval($value["total"]) - $purchase;
                                        $gain_total +=$gain; 
                                       
                                       @endphp
                                        
                                        {{number_format($gain,2)}}</td>
                                </tr>
                               
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
