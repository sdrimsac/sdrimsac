<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Kardex</title>
    </head>
    <body>
        <div>
            <h3 align="center" class="title"><strong>Reporte Kardex</strong></h3>
        </div>
        <br>
        @if(!empty($records))
            <div class="">
                <div class=" ">
                    <table class="">
                        <thead>
                            <tr>

                                <th>PERIODO</th>
                                <th>NUMERO CORRELATIVO CUO</th>
                                <th>NUMERO CORRELATIVO DEL ASIENTO</th>
                                <th>CODIGO DE ESTABLECIMIENTO</th>
                                <th>CODIGO DEL CATALOGO</th>
                                <th>TIPO DE EXISTENCIA</th>
                                <th>CODIGO PROPIO DE LA EXISTENCIA</th>
                                <th>CODIGO SISTEMA</th>
                                <th>CODIGO CBSO</th>
                                <th>FECHA DE EMISION</th>
                                <th>TIPO DE DOCUMENTO</th>
                                <th>Nº SERIE DE DOCUMENTO</th>
                                <th>Nº DOCUMENTO</th>
                                <th>TIPO DE OPERACION EFECTUADA</th>
                                <th>DESCRIPCION DE PRODUCTO</th>
                                <th>NOMENCLATURA</th>
                                <th>ENTRADA</th>
                                <th>SALIDA</th>
                                <th>SALDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                //dd($records);
                            ?>
                            @foreach($records as $key => $value)

                                @if($value['view']==true)
                                @if($value['output']!=0 || $value['input']!=0)
                            <tr>
                                <td class="celda"> {{ substr($value['date_of_issue'],6,4). substr($value['date_of_issue'],3,2) }}00</td>
                                <td class="celda">{{$value['item_id']}}</td>
                                <td class="celda">
                                    {{$value['asiento']}}
                                </td>
                                <td>0000</td>
                                <td class="celda">{{$value['item_id']}}</td>
                                <td class="celda">{{$value['item_id']}}</td>
                                <td class="celda">{{$value['item_id']}}</td>
                                <td class="celda">0</td>
                                <td class="celda">0</td>
                                <td class="celda">{{ $value['date_of_issue'] }}</td>
                                <td class="celda">
                                    {{$value['document_type_id']}}

                                </td>
                                <td class="celda">
                                    {{ $value['series']}}
                                </td>
                                <td class="celda">
                                    {{$value['number']}}
                                </td>
                                <td class="celda">
                                    {{$value['operacion_efectuada']}}
                                </td>
                                <td class="celda">
                                    {{$value['item_name']}}</td>
                                <td class="celda">
                                    {{$value['unit_type_id']}}</td>
                                <td class="celda">
                                    @if($value['asiento']=="C-2")
                                        {{$value['input']}}
                                    @endif
                                </td>
                                <td class="celda">
                                    @if($value['asiento']=="V-1")
                                        {{ substr($value['output'],1,strlen($value['output'])) }}
                                    @endif

                                </td>

                                    <td class="celda">{{number_format($value['balance'], 4, ".", "")}}</td>
                                </tr>
                            @endif
                            @endif
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
