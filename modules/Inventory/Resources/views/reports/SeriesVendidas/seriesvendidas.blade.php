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
            
        </div>
        @if(!empty($datosSeries))
        
            <div class="">
                <div class=" ">
               
                    <table class="">
                        <thead class="thead">
                            <tr style="background-color:silver" > 
                                <th class="th" style="border: 1px solid black !important; background-color:silver  ">#</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">Almacen</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">COD. INTERNO</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">PRODUCTO</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">SERIE</th>

                                <th class="th" style="border: 1px solid black !important; background-color:silver">CLIENTE</th>                                
                                <th class="th" style="border: 1px solid black !important; background-color:silver">NR. DOC.</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">F. VENTA</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">P. VENTA</th>


                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($datosSeries as $index => $value)
                            
                            <tr class="tr" style="border: 1px solid black !important; ">
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$index+1}}
                                    
                                </td><td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['establish_description']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    &nbsp;{{$value['codigoInterno']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    {{$value['descripcion']}}
                                    
                                    
                                </td>
                                <td style="border: 1px solid black !important; ">&nbsp;{{$value['series']}}</td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    
                                    {{$value['pers_name']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                    
                                    {{$value['docSeries']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                   
                                    {{$value['docDate']}}
                                    
                                </td>
                                <td class="celda" style="border: 1px solid black !important; ">
                                   
                                    {{$value['itemValue']}}
                                    
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
