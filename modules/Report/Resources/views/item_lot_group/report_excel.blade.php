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
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                @if(!empty($records))
                {{-- <tr>
                        <td>
                            <p><b>Producto: </b></p>
                        </td>
                        <td align="center">
                            <p><strong>{{($records[0]->item->internal_id) ? $records[0]->item->internal_id.' -':''}} {{$records[0]->item->description}}</strong></p>
                </td>
                </tr> --}}
                @endif
                <tr>
                    <td colspan="6" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px; font-weight: bold;">
                        <h3 class="title"><strong>LOTES</strong></h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Empresa:</strong>{{$company->name}}</p>
                    </td>
                    <td colspan="2" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Fecha: </strong>{{date('Y-m-d')}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                        <p><strong>Establecimiento: </strong>{{$establishment->address}} - {{$establishment->department->description}} - {{$establishment->district->description}}</p>
                    </td>
                    <td colspan="2" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px; font-weight: bold;">
                    <p><strong>Ruc: </strong>{{$company->number}}</p>
                </td>
            </table>
        </div>
        <br>
        @if(!empty($records))
        <div class="">
            <div class=" ">

                <table class="">
                    <thead>
                        <tr>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Lote</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Producto</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Fecha de vencimiento</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Almacén</th>
                            <th class="" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $key => $value)
                        <tr>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$loop->iteration}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$value->code}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$value->item->description}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$value->date_of_due}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$value->warehouse->description}}</td>
                            <td class="celda" style="border: 2px solid black; text-align: center;">{{$value->quantity}}</td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </table>
    @else
    <div>
        <p>No se encontraron registros.</p>
    </div>
    @endif
</body>

</html>