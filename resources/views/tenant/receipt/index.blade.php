<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>Recibo de Pago</title>
    <style>
        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: .5cm;
            margin-left: .5cm;
            margin-right: .5cm;
            margin-bottom: .5cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            /** Extra personal styles **/
            color: white;
            text-align: center;
            line-height: .5cm;
        }

        .header_left {
            width: 60%;
            height: auto;
            float: left;
            height: 2cm;
            text-align: left;
            border: 1px solid;
            display: block;
        }

        .header_right {
            width: 40%;
            height: auto;
            float: right;
            height: 2.cm;

        }

        .full-width {
            width: 100%;
        }

        .margin-right {
            margin-right: 10px;
        }

        .border_round {
            border: thin solid #333 !important;
            border-radius: 5px !important;
            padding: 5px;
            height: 2.cm;
            /** Extra personal styles **/
            color: #000;
            text-align: center;

        }

        thead {
            background-color: #333;
            color: #fff;


        }

        .width {
            width: 100%;
            height: 2cm;
            float: left;
            border: 1px solid;
        }

        @page {
            margin: 0cm 0cm;
            border: 1px solid;
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

        td {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .logotipo {
            width: 250px !important;
            height: 2cm !important;
        }

        .negrita {
            font-weight: bold;
        }

        .detalle {
            margin-top: .5cm;
            margin-bottom: .5cm;
        }

        .border-right {
            border-right: 1px solid #333;
        }

        .border-top {
            border-top: 1px solid #333;
        }
    </style>
</head>

<body>
    <table border="0" class="full-width">
        <tr>
            <td height="80px" valign="top">
                <table border="0" class="full-width">
                    <tr>
                        <td width="20%" valign="top" align="center">
                            @if ($company->logo)
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                    alt="{{ $company->name }}" class="full-width logotipo">
                            @else
                                <div style="width:100%;display:block;height:40px"></div>
                            @endif
                        </td>
                    </tr>

                </table>
            </td>

        </tr>
        <tr>
            <td valign="top" width="100%" align="center">
                <div class="border_round text-center" style="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="full-width text-center">
                        <tr>
                            <td>
                                <h5 class="text-center p-0" style="font-size: 13px;">{{ 'RUC ' . $company->number }}
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5 class="text-center p-0" style="font-size: 16px;"><b>RECIBO Nº
                                        {{ str_pad($data['number'], 7, '0', STR_PAD_LEFT) }}</b></h5>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ $establishment->description !== '-' ? $establishment->description : '' }}
                                
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <table class="full-width" border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="100%" align="left" valign="top">
                            <div class="border_round" style="margin-bottom:5px !important">
                                <table border="0" class="full-width" border="0">
                                    <tr>
                                        <td class="negrita">CLIENTE : </td>
                                        <td>{{ strtoupper($data->customer->name) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="negrita">Nº DNI : </td>
                                        <td>{{ strtoupper($data->customer->number) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="negrita">TELEFONO : </td>
                                        <td>{{ strtoupper($data->customer->telephone ?? '-') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <div class="border_round" style="height: 1.1cm !important;">
                                <table border="0" class="full-width" border="0">
                                    <tr>
                                        <td class="negrita">Fecha : </td>
                                        <td>{{ \Carbon\Carbon::parse($data->date_of_issue)->format('d-m-Y') }}</td>

                                        <td class="negrita">Hora : </td>
                                        <td>{{ strtoupper($data->hour) }}</td>
                                    </tr>

                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="5"></td>
                    </tr>
                    <tr>
                        <td class="full-width" valign="top">
                            <table border="0" cellspacing="0" cellpadding="0" class="full-width" width="100%"
                                style="border: 1px solid #333;">

                                <tbody>

                                    <tr>
                                        <td colspan="2" align="right" valign="top" class="border-right border-top"
                                            style="padding: 5px !important;">
                                            <b>CREDITO OTORGADO S/.</b>
                                        </td>
                                        <td align="center" valign="top" class="border-top"
                                            style="padding: 5px !important;">
                                            <b><span style="font-size: 17px;">
                                                    {{ number_format($data->sale_note->total + $interes, 2) }}
                                                    <?php
                                                    //dd($data->amount);
                                                    ?>
                                                </span></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="right" valign="top" class="border-right border-top"
                                            style="padding: 5px !important;">
                                            <b>ADELANTOS ANTERIOR S/.</b>
                                        </td>
                                        <td align="center" valign="top" class="border-top"
                                            style="padding: 5px !important;">
                                            <b><span style="font-size: 17px;">
                                                    {{ number_format($payments->total_payment - $data->amount, 2) }}
                                                </span></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="right" valign="top" class="border-right border-top"
                                            style="padding: 5px !important;">
                                            <b>MONTO PAGADO S/.</b>
                                        </td>
                                        <td align="center" valign="top" class="border-top"
                                            style="padding: 5px !important;">
                                            <b><span style="font-size: 17px;">
                                                    {{ $data->amount }}
                                                </span></b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" align="right" valign="top" class="border-right border-top"
                                            style="padding: 5px !important;">
                                            <b>DEUDA PENDIENTE S/.</b>
                                        </td>
                                        <td align="center" valign="top" class="border-top"
                                            style="padding: 5px !important;">
                                            <b><span style="font-size: 17px;">


                                                    {{ number_format($deuda + $interes, 2) }}
                                                </span></b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="margin-top: 15px" border="0" class="full-width" width="100%">
                                <tr>
                                    <td class="negrita">CAJERO : </td>
                                    <td>{{ strtoupper($user->name) }}</td>
                                </tr>
                            </table>
                            {{-- <table border="0" class="full-width" width="100%">
                                <tr>
                                    <td colspan="3" height="80px"></td>
                                </tr>
                                <tr>
                                    <td height="50px" width="45%" align="center"
                                        style="border-top: 1px solid #333;">RECIBI CONFORME</td>
                                    <td width="10%"> </td>
                                    <td align="center" width="45%" style="border-top: 1px solid #333;">FIRMA DEL
                                        CLIENTE</td>
                                </tr>
                            </table> --}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    </div>
