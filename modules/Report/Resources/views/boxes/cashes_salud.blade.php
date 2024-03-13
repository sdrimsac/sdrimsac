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
            font-size: 11px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border:1px solid #ccc;
        }

        .table {
            border: 0.1px solid #ccc;
        }

        .celda {
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_center {
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_right {
            text-align: right;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        tr:nth-child(even) {}

        .nth-child {
            background-color: transparent;
        }

        .border-bottom {
            border-bottom: 0.1px solid #ccc;
        }

        td {
            padding: 5px;
        }

        th {
            padding: 5px;
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid #ccc;
        }

        .headers {
            padding: 5px !important;
            border-bottom: 0.1px solid #ccc;
            height: 25px;
            font-size: 14px !important;
        }

        .title {
            font-weight: bold;
            padding: 5px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        p>strong {
            margin-left: 5px;
            font-size: 13px;
        }

        thead {
            font-weight: bold;
            color: #000;
            text-align: center;
        }

        .title {
            font-weight: bold;
            padding: 3px;
            font-size: 20px !important;
            text-decoration: underline;
        }

        .encabezado {
            background-color: #ccc;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 10px;
        }

        .categoria {
            background-color: #eee;
            text-transform: uppercase;
            padding: 5px;
            padding-left: 50px;
        }

        .celda_loop {
            width: 10% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_descrip {
            width: 60% !important;
            text-align: left;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        .celda_date {
            width: 30% !important;
            text-align: center;
            padding: 5px;
            border: 0.1px solid #ccc;
        }

        p>strong {
            margin-left: 5px;
            font-size: 11px;
        }

        header {
            position: fixed;
            height: 1cm;
            color: #000;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            font-family: arial;

        }

        footer {
            position: fixed;
            bottom: 10px;
            height: 0.8cm;
            color: #000;
            text-align: center;
            font-size: 11px;
            padding: 12px;
            font-family: Arial;
            padding: 10px;
        }

        @page {
            margin: 0.5cm 0.5cm 0cm 0.5cm;
            font-family: sans-serif;
        }
        td{
            border-bottom: 1px solid #ccc;
        }
        td,
        th {
            font-size: 10px !important;
            height: 15px;
        }

        body {
            margin: 1.5cm 0.5cm 0.5cm 0.5cm;
        }

    </style>
</head>
<body>
    <header>
    
    </header>

    <div>
        <table cellpadding="0" cellspacing="0"
            style="border-collapse: collapse;border:1px solid #ddd; margin-top: 10px !important;">
            <tr>
                <td class="headers" height="20">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="headers">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
            </tr>
        </table>
    </div>

    <div>
        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse; border:1px solid #ddd; margin-top: 10px !important;">
            <thead>
                <tr>
                    <th class="encabezado">Código</th>
                    <th class="encabezado">Concepto</th>
                    <th class="encabezado">Subtotal</th>
                    <th class="encabezado">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items_by_category as $category => $items)
                <tr>
                    <td class="categoria"></td>
                    <td class="categoria">{{ $category }}</td>
                    <td class="categoria"></td>
                    @php
                    $category_sum = array_sum(array_column($items, 'total'));
                    @endphp
                    <td class="categoria">{{$category_sum}}</td>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td class="celda_loop">{{ $item['barcode'] }}</td>
                    <td class="celda_loop">{{ $item['description'] }}</td>
                    <td class="celda_descrip text-end">{{ $item['total'] }}</td>
                    <td class="celda_date"></td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

</body>


</html>
