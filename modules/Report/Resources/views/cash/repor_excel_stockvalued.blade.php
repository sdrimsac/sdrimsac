<?php

function format_unit($row){
    $max_quantity_item = $row["max_quantity_item"]??0;
  
    $unit_type = $row["unit_type"];
    $unit_item = $row["unit_item"];
    $stock = number_format($row["stock"],2);
    if($max_quantity_item==0){
        return $stock." ".$unit_type;
    }

    $full = intdiv($stock,$max_quantity_item);
    $rest = $stock %$max_quantity_item;
    $text = "";
    if($full>0){
        $text .= $full." ".$unit_item ?? $unit_type;
    }
    if($rest>0||$full==0){
        $text .= $rest." ".$unit_type;
    }
    return $text;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
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
                text-align: right !important;
                padding: 2px;
                border: 0.1px solid black;
            }
            
            .th {
                padding: 2px;
                text-align: center;
                border-color: black;
                border: 1px solid black;
            }
            tr {
                padding: 2px;
                text-align: center;
                border-color: black;
                border: 1px solid black;
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
                        <p><strong>Valorización de productos</strong></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <p><strong>Empresa: </strong>{{$company->name}}</p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="2">
                        <p><strong>Ruc: </strong>{{$company->number}}</p>
                    </td>
                </tr>
            
            </table>
        </div>
        @if(!empty($records))
        
            <div class="">
                <div class=" ">
               
                    <table class="">
                        <thead class="thead">
                            <tr style="background-color:silver" > 
                                <th class="th" style="border: 1px solid black !important; background-color:silver ">#</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Producto</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Almacén</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Stock</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Precio de Compra </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Total Compra </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Precio de Venta </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Total Venta </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Ganancia</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($records as $index => $value)
                            
                            <tr class="tr" style="border: 1px solid black !important; ">
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$index+1}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['description']}}
                                    
                            </td>
                            <td class="celda" style="border: 1px solid black !important; ">
                                {{$value['warehouse_description']}}
                                
                            </td>
                            <td class="celda" style="border: 1px solid black !important; ">
                                {{format_unit($value)}}
                                
                                
                            </td>
                                
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['purchase_unit_price'], 2)}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['total_purchase'], 2)}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['sale_unit_price'], 2)}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['total'], 2)}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['gain'], 2)}}
                                    
                                </td>
                            
                                
                            </tr>
                           
                            @endforeach
                           
                            
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
