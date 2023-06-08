<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="application/pdf; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Registros</title>
    <style>
        html {
            font-family: sans-serif;
            font-size: 12px;
        }

        @page {
            margin: 0.5cm 0.5cm 0.5cm 0.5cm;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid black;
        }

        .celda {
            text-align: center;
            border: 0.1px solid black;
        }

        th {
            text-align: center;
            border-color: #409EFF;
            border: 0.1px solid black;
        }

        .title {
            font-weight: bold;
            font-size: 20px !important;
            text-decoration: underline;
        }


        thead {
            font-weight: bold;
            background: #409EFF;
            color: white;
            text-align: center;
        }

        .td-custom {
            vertical-align: top;
            padding: 2px;
        }

        .p-2 {
            padding: 2px;
        }
    </style>
</head>

<body>
    <div>
        <p align="center" class="title"><strong>Registros</strong></p>
    </div>
    <div style="margin-top:20px; margin-bottom:20px;">


        <table>
            <tr>
                <td class="td-custom">
                    <strong>Empresa: </strong>{{ $company->name }}
                </td>
                <td class="td-custom">
                    <strong>Fecha reporte: </strong>{{ date('Y-m-d') }}
                </td>
            </tr>
            <tr>
                <td class="td-custom">
                    <strong>Ruc: </strong>{{ $company->number }}
                </td>
                <td class="td-custom">
                    <strong>Establecimiento: </strong>{{ $establishment->address }} -
                    {{ $establishment->department->description }} - {{ $establishment->district->description }}
                </td>
            </tr>
        </table>
    </div>
    @if ($records->count())
        <div class=" ">

            <table class="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Suministro</th>
                        <th>Télf.</th>
                        <th>Cliente</th>
                        <th>Zona</th>
                        <th>Plan</th>
                        <th>Deuda</th>
                        @if ($category == 2)
                            <th>Suspensión</th>
                        @endif
                        <th>Fecha de pago</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($records as $key => $value)
                        <tr>


                            <td class="p-2 celda">{{ $key + 1 }}</td>
                            <td class="p-2 celda">{{ $value->supplie }}</td>
                            <td class="p-2 celda">{{ $value->person->telephone }}</td>
                            <td class="p-2 celda">{{ $value->person->name }}</td>
                            <td class="p-2 celda">{{ $value->person->zone ? $value->person->zone->description : '-' }}
                            </td>
                            <td class="p-2 celda">{{ $value->get_name_of_plan() }}</td>
                            <td class="p-2 celda">{{ $value->get_last_payment() }}</td>
                            @if ($category == 2)
                                <td class="p-2 celda">{{ $value->get_suspension_description() ?? '-' }}</td>
                            @endif
                            <td class="p-2 celda">
                                {{ $value->get_date_pay() }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="callout callout-info">
            <p>No se encontraron registros.</p>
        </div>
    @endif
</body>

</html>
