<?php

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
       
     
        <div style="margin-top:20px; margin-bottom:20px;">
            <table>
                <tr>
                    <td colspan="6">
                        <p><strong>Listado documentos sin procesar </strong></p>
                    </td>
                </tr>
                <tr>
                    
                </tr>
            </table>
        </div>
        @if(!empty($infoCompleta))
        
            <div class="">
                <div class=" ">
               
                    <table class="">
                        <thead class="thead">
                            <tr style="background-color:silver" > 
                                <th class="th" style="border: 1px solid black !important; background-color:silver  ">#</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">id_doc</th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">STATUS </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">SOAP TIPO </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">SERIE </th>

                                <th class="th" style="border: 1px solid black !important; background-color:silver">N DOCUMENTO</th>                                
                                <th class="th" style="border: 1px solid black !important; background-color:silver">FECHA DEL DOCUMENTO </th>
                                <th class="th" style="border: 1px solid black !important; background-color:silver">NOMBRE DEL PROYECTO </th>


                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($infoCompleta as $index => $value)

                                @foreach ($value as $index2 => $data )
                                
                                <tr class="tr" style="border: 1px solid black !important; ">
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$index2+1}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['document_id']}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{($data['statusDoc'])}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['modo']}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['document_series']}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['document_number']}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['document_date_of_issue']}}
                                    </td>
                                    <td class="celda" style="border: 1px solid black !important; ">
                                        {{$data['proyecto']}}
                                    </td>
                                    
                                </tr>
                            
                                @endforeach
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
