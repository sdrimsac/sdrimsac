<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type"
        content="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de crédito</title>
</head>

<body>
    <div>
        <h3 align="center" class="title"><strong>Lista de crédito</strong></h3>
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
                </td>
                <td align="center">

                </td>
            </tr>
        </table>
    </div>
    <br>
    @if (!empty($records))
        <div class="">
            <div class=" ">
                <table class="">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Establecimiento</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $key => $value)
                            @php
                                $orden_id = $value->orden_id;
                                $credit_list = \App\Models\Tenant\CreditList::where('orden_id', $orden_id)->first();
                                $seller = optional($credit_list->seller)->name;
                                $establishment = optional($credit_list->establishment)->description;
                                $price = $value->price;
                                $quantity = $value->quantity;
                                $total = $price * $quantity;
                                $product = optional($value->food)->description;
                                $total = number_format($total, 2, '.', '');
                            @endphp
                            <tr>
                                <td class="celda">{{ $key + 1 }}</td>
                                <td class="celda">{{ $establishment }}</td>
                                <td class="celda">{{ $product }}</td>
                                <td class="celda">
                                    {{ $quantity }}
                                </td>
                                <td class="celda">
                                    {{ $total }}
                                </td>
                                <td class="celda">
                                    {{ $seller }}
                                </td>


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
