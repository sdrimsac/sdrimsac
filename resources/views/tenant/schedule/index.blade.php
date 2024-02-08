<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Recibo de Pago</title>
    <style>
        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: .5cm;
            margin-left: .5cm;
            margin-right: .5cm;
            margin-bottom: .5cm;
        }

        .logotipo {
            width: 250px !important;
            height: 1.5cm !important;
            text-align: center;
        }

        td {
            font-family: Arial, sans-serif;
            font-size: 12px;
            height: 20px !important;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .detalle {
            margin-top: 1.8cm;
            margin-bottom: 1cm;
        }

        .border-right {
            border-right: 1px solid #333;
        }

        .border-top {
            border-top: 1px solid #333;
        }

        @page {
            margin-top: 5px;
            margin-left: 5px;
            margin-right: 0px;
        }

        .border-bottom,
        thead {
            font-family: Arial, sans-serif;
            font-size: 12px;
            height: 20px !important;
            border-bottom: 0.1px solid #ccc;
        }

        h4 {
            font-weight: bold;
            font-size: 16px;
            margin: 0px;
            padding: 2px;

        }

        h1,
        h2,
        h3,
        h5,
        h6 {
            margin: 0px;
            padding: 2px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }
    </style>

<body>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top" class="text_header" align="center">
                @if ($company->logo)
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                        alt="{{ $company->name }}" class="logotipo">
                @endif
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3 style="font-size:15px !important">
                    CRONOGRAMA DE PAGOS
                </h3>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
        <tbody>
            <tr>
                <td colspan="2" valign="top" class="text_header" align="left">
                    <b>FECHA DE EMISION : {{ date('d-m-Y H:i:s') }}</b>
                </td>
                {{-- <td align="left" valign="top">
                      <b>HORA : {{date('H:i:s')}}</b>
                    </td> --}}
            </tr>
            <tr>
                <td colspan="2" valign="top" class="border-bottom">
                    <span class="patient"><b> CLIENTE : </b> <br>{{ $sale->person->name }}</span><br>
                </td>

            </tr>
            <tr>
                <td colspan="2" valign="top" class="border-bottom">
                    <span class="patient"><b> CELULAR : </b> <br>{{ $sale->person->telephone }}</span><br>
                </td>
            </tr>
            <tr>
                <td colspan="2" valign="top" class="border-bottom">
                    <span class="patient"><b> DIRECCION : </b> <br>{{ $sale->person->address }}</span><br>
                </td>
            </tr>

        </tbody>
    </table>
    <table class="full-width" width="100%" border="0" cellspacing="0" cellpadding="0"
        style="border:1px solid #ccc;">
        <thead>
            <tr>
                <th>#</th>
                <th>FECHA PAGO</th>
                <th>MONTO DE PAGO</th>
                <th>DETALLE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $amount = 0;
            ?>
            @foreach ($data as $row)
                <?php
                $amount = $amount + $row['amount'] - $row['amount_paid'];
                ?>
                <tr>
                    <td align="center" class="border-bottom">
                        {{ $loop->iteration }}
                    </td>
                    <td align="center" class="border-bottom">
                        {{ \Carbon\Carbon::parse($row->date_payment)->format('d-m-Y') }}
                    </td>
                    <td align="right" class="border-bottom" style="padding-right:20px">
                        {{ number_format($row->amount, 2) }}
                    </td>
                    <td align="right" class="border-bottom" style="padding-right:20px">
                        @if ($row->paid)
                            <small>
                                Cancelado
                                <br> S/ {{ $row->amount_paid }}
                            </small>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" align="right" style="padding-right:20px">
                    <b>Total a Pagar S/. {{ number_format($amount) }}</b>
                </td>
                <td></td>
            </tr>

        </tbody>
    </table>
</body>
