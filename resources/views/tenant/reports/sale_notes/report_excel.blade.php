<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compras</title>
</head>
<!-- esto el el repote de nota de venta -->
<body>
    <table>
        <div style="margin-top:20px; margin-bottom:15px;">
            <table>
                <tr>
                    <td colspan="13" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 14px;">
                        <h3 align="center" class="title"><strong>Reporte Nota de Venta </strong></h3>
                    </td>
                </tr>
                <tr>
                    <td  colspan="13" style="border: 2px solid black; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Empresa: </strong>{{$company->name}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Ruc: </strong>{{$company->number}}</p>
                    </td>
                    <td align="center" colspan="6" style="border: 2px solid black; text-align: center; background-color: #DCDCDC; font-size: 12px;">
                        <p><strong>Fecha: </strong>{{date('Y-m-d')}}</p>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        @if(!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">#</th>
                            <th class="text-center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Fecha Emisión</th>
                            <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Cliente</th>
                            <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Nota de Venta</th>
                            <th style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Estado</th>
                            <th class="text-center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Moneda</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">T.Exportación</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">T.Inafecta</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">T.Exonerado</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">T.Gravado</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">T.Igv</th>
                            <th class="text-right" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Total</th>
                            <th class="text-center" style="border: 2px solid black; text-align: center; background-color: #DCDCDC;">Comprobantes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($records as $key => $value)
                        <tr>
                            <td style="border: 2px solid black; text-align: center;">{{$loop->iteration}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{$value->date_of_issue}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{$value->customer->name}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{$value->identifier}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{$value->state_type->description}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{$value->currency_type_id}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total_exportation }}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total_unaffected }}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total_exonerated }}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total_taxed}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total_igv}}</td>
                            <td style="border: 2px solid black; text-align: center;">{{ $value->total}}</td>
                            <td style="border: 2px solid black; text-align: center;">
                                @foreach ($value->documents as $doc)
                                <label class="d-block">{{$doc->number_full}}</label>
                                @endforeach
                            </td>
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