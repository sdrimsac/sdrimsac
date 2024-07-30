<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORTE METODOS DE PAGO</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9">
                    {{ $company->name }} - {{ $company->number }}
                </td>
            </tr>
            @if ($establishment)
                <tr>
                    <td colspan="9">
                        <strong>Establecimiento: </strong> {{ $establishment->name }}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="9">
                    <strong>Desde:</strong> {{ $dateStart }}  |  <strong>Hasta:</strong> {{ $dateEnd }}
                </td>
            </tr>
        </thead>
    </table>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">USUARIO</th>
                            <th class="">FECHA</th>
                            <th class="">HORA</th>
                            <th class="">CLIENTE</th>
                            <th class="">DOCUMENTO</th>
                            <th class="">METODO DE PAGO</th>
                            <th class="">N° OPERACION</th>
                            <th class="">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($records as $key => $value)
                            @php
                                $user = $value->user->name;
                                $date = $value->date;
                                $time = $value->created_at->format('H:i:s');
                                $customer = null;
                                $customer = null;
                                if ($value->document) {
                                    $customer = $value->document->customer;
                                } elseif ($value->salenote) {
                                    $customer = $value->salenote->customer;
                                } elseif ($value->sale_note_payment) {
                                    $customer = $value->sale_note_payment->associated_record_payment->customer;
                                } elseif ($value->document_payment) {
                                    $customer = $value->document_payment->document->customer;
                                }
                                $customer_name = $customer ? $customer->name : null;
                                $customer_document = $customer ? $customer->number : null;
                                $method = $value->method;
                                $operation_number = $value->operation_number;
                                $amount = $value->amount;

                            @endphp
                            <tr>
                                <td class="celda">
                                    {{ $key + 1 }}
                                </td>
                                <td class="celda">{{ $user }}</td>
                                <td class="celda">{{ $date }}</td>
                                <td class="celda">{{ $time }}</td>
                                <td class="celda">{{ $customer_name }}</td>
                                <td class="celda">{{ $customer_document }}</td>
                                <td class="celda">{{ $method }}</td>
                                <td class="celda">{{ $operation_number }}</td>
                                <td class="celda">{{ $amount }}</td>

                            </tr>
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
