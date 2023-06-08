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
            <h3 align="center" class="title"><strong>REPORTE POR PRODUCTO VENCIDOS</strong></h3>
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
            @php
                $acum_total_taxed=0;
                $acum_total_igv=0;
                $acum_total=0;
                
                $serie_affec = '';
                $acum_total_exonerado=0;
                $acum_total_inafecto=0;

                $acum_total_free=0;

                $acum_total_taxed_usd = 0;
                $acum_total_igv_usd = 0;
                $acum_total_usd = 0;
                $acum_quantity=0;
                    @endphp
            <div class="">
                <div class=" ">
                 
                    <table>
                        <thead>
                            <tr>
                                <th class=""><strong>#</strong></th>
                                <th class=""><strong>Fecha Vencimiento</strong></th>
                                <th class=""><strong>Producto</strong></th>
                                <th class=""><strong>Codigo Interno</strong></th>
                                <th class=""><strong>Precio de Compra</strong></th>
                                <th class=""><strong>Precio de Venta</strong></th>
                                <th class=""><strong>Stock</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $key => $value)
                            <tr>
                                <td class="celda center">{{$loop->iteration}}</td>
                                <td class="celda center">{{ $value->date_of_due }}
                    </td> 
                                <td class="celda">{{$value->description}}</td>
                                <td class="celda">{{$value->internal_id}}</td>
                                <td class="celda">{{$value->purchase_unit_price}}</td>
                                <td class="celda">{{$value->sale_unit_price}}</td>
                                <td class="celda">{{$value->stock}}</td>
                            </tr>
                            @php
 
                                $acum_quantity ++; 

                            @endphp
                            @endforeach
                            <tr>
                                <td class="" colspan="5"></td> 
                                <td class=""><b>Total de Productos</b></td>
                                <td class=""><b>{{$acum_quantity}}</b></td>
                                <td></td>
                            </tr> 
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
