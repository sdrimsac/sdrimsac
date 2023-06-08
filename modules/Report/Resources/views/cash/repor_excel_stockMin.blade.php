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
                text-align: center;
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
                        <p><strong>Listado de Productos para Orden De Compra </strong></p>
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
                  
                    <td colspan="2">
                        <p><strong>N Orden de Compra:  </strong>{{$numOrdengen}}</p>
                    </td>
                 
                </tr>
                <tr>
                    <td colspan="2">
                        <p><strong>Total: </strong>{{$sumOrden[0]['ordc_total_monto']}}</p>
                    </td>
                  
                    
                 
                </tr>
            </table>
        </div>
        @if(!empty($ordenesCompra))
        
            <div class="">
                <div class=" ">
               
                    <table class="">
                        <thead class="thead">
                            <tr style="background-color:silver" > 
                                <th class="th" style="border: 1px solid black !important; background-color:silver  ">#</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Producto</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Precio de Compra </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Codigo Interno </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Cantidad a Comprar </th>

                                <th class="th" style="border: 1px solid black !important; background-color:silver">Proveedor</th>                                
                                <th class="th" style="border: 1px solid black !important; background-color:silver">N Telefono </th>


                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($ordenesCompra as $index => $value)
                            
                            <tr class="tr" style="border: 1px solid black !important; ">
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$index+1}}
                                    
                                </td><td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['description']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{number_format($value['unit_price'], 2)}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['barcode']}}
                                    
                                    
                                </td>
                                <td style="border: 1px solid black !important; "></td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['name']}}
                                    
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['number']}}
                                    
                                    
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
