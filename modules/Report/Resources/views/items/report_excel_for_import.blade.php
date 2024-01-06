<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>REPORTE POR PRODUCTO</strong></h3>
    </div>
    <br>
    <div style="margin-top:20px; margin-bottom:15px;">
        <table>

            <tr>
                <td>
                    <p><b>Empresa: </b></p>
                </td>
                <td align="center">
                    <p><strong>{{ $company->name }}</strong></p>
                </td>
                <td>
                    <p><strong>Fecha: </strong></p>
                </td>
                <td align="center">
                    <p><strong>{{ date('Y-m-d') }}</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Ruc: </strong></p>
                </td>
                <td align="center">{{ $company->number }}</td>
                <td>
                    <p><strong>Establecimiento: </strong></p>
                </td>
                <td align="center">{{ $establishment->address }} - {{ $establishment->department->description }} -
                    {{ $establishment->district->description }}</td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                @php
                    
                @endphp
                <table class="">
                    <thead>
                        <tr>
                            <th> Descripción</th>
                            <th> Nombre Secundario</th>
                            <th> Código Interno</th>
                            <th> Codigo Barra</th>
                            <th> Código Sunat</th>
                            <th> Código Tipo de Unidad</th>
                            <th> Código Tipo de Moneda</th>
                            <th> Precio Unitario Venta</th>
                            <th> Codigo Tipo de Afectación del Igv Venta</th>
                            <th> Tiene Igv</th>
                            <th> Precio Unitario Compra</th>
                            <th> Codigo Tipo de Afectación del Igv Compra</th>
                            <th> Stock</th>
                            <th> Stock Mínimo</th>
                            <th> Categoria</th>
                            <th> Marca</th>
                            <th> Area</th>
                            <th> Series</th>
                            <th> p1_desc</th>
                            <th> p1_cant</th>
                            <th> p1_precio</th>
                            <th> p2_desc</th>
                            <th> p2_cant</th>
                            <th> p2_precio</th>
                            <th> p3_desc</th>
                            <th> p3_cant</th>
                            <th> p3_precio</th>
                            <th> p4_desc</th>
                            <th> p4_cant</th>
                            <th> p4_precio</th>
                            <th> Cantidad Maxima</th>
                            <th> Contenedor</th>
                            <th> Código de lote</th>
                            <th> Fecha de Vencimiento d/m/a</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
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
