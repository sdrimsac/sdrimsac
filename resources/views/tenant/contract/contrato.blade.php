@php
    $configuration = \App\Models\Tenant\Configuration::select('show_logo_in_documents')->first();
    $stablishment = $establishment;

    if (!function_exists('formatDate')) {
        function formatDate($dateString)
        {
            $date = \Carbon\Carbon::parse($dateString);

            $months = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre',
            ];

            return $date->format('d') . ' de ' . $months[$date->format('n')] . ' del ' . $date->format('Y');
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin-top: 5px;
            margin-left: 20px;
            margin-right: 20px;
            padding: 1px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            /* font-weight: normal; */
            line-height: 1.42857143;
            text-align: justify;

        }

        @page {
            margin-top: 5px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        /*clase para deshacer los estilos de la tabla */
        .no-border {
            border: none;
        }

        .mt-2 {
            margin-top: 5px;
        }

        .full-width {
            width: 100%;
        }

        .company_logo {
            max-height: 100px;
        }

        .company_logo_box {
            width: 200px;
        }

        .company_logo_ticket {
            max-width: 200px;
            max-height: 80px
        }
    </style>
</head>

<body>
    <table class="full-width no-border">
        <tr>

            @if ($stablishment->logo || $stablishment->document_logo)
                <td class="no-border" width="40%" height="20px">
                    <div>
                        @if ($stablishment->document_logo)
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 230px;">
                        @else
                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 230px;">
                        @endif
                    </div>
                </td>
            @else
                @if ($company->logo)
                    <td class="no-border" width="40%" height="20px">
                        <div>
                            @if ($company->document_logo)
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 230px;">
                            @else
                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                    alt="{{ $company->trade_name }}" class="company_logo" style="max-width: 230px;">
                            @endif
                        </div>
                    </td>
                @else
                    <td class="no-border" width="40%" height="20px">
                        {{-- <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px"> --}}
                    </td>
                @endif
            @endif

        </tr>

    </table>
    <div>
        <h3 class="text-center bold line">
            CONTRATO DE COMPRA-VENTA
        </h3>
        @php
            $date_of_issue = \Carbon\Carbon::parse($sale->date_of_issue);

            $months = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre',
            ];

            $date_description =
                'Pichanaqui, ' .
                $date_of_issue->format('d') .
                ' de ' .
                $months[$date_of_issue->format('n')] .
                ' del ' .
                $date_of_issue->format('Y');
            $customer_name = $sale->customer->name;
            $customer_number = $sale->customer->number;
            $customer_address = $sale->customer->address;
        @endphp
    </div>
    <p>
        En la ciudad de {{ $date_description }}, fueron presentes en forma voluntaria
        y en mutuo acuerdo; en el que comparen de una parte en calidad de vendedor CREDIHOGAR, con RUC:10753874106 y de
        otra
        parte en calidad de comprador sr(a) <strong>
            {{ strtoupper($customer_name) }}
        </strong> Identificado con DNI: <strong>
            {{ $customer_number }}
        </strong> de
        nacionalidad peruana, domiciliado en
        @if ($customer_address && $customer_address != '-')
            <strong>
                {{ strtoupper($customer_address) }}
            </strong>
        @else
            ______________________________________________________
        @endif

        provincia de Chanchamayo,
        Distrito Pichanaqui Región Junín, siendo mayores de edad conscientes de sus actos en pleno uso de facultad de
        sus
        derechos civiles e inteligentes en el idioma castellano se da convenio al siguiente contrato de mutuo acuerdo:
    </p>
    <p>
        <strong>PRIMERO - DESCRIPCIÓN DEL PRODUCTO -</strong> Por el presente acto KATERIN ESTEFANI ROJAS ROMAN
        (vendedora) brinda la
        cantidad de ___ productos las cuales describen:
    </p>

    <table>
        <thead>
            <tr>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">MARCA</th>
                <th class="text-center">MODELO</th>
                <th class="text-center">SERIE</th>
                <th class="text-center">S/.</th>
            </tr>

        </thead>
        <tbody>
            @foreach (range(1, 4) as $index)
                <tr>
                    <td style="height: 25px; width: 35%;"></td>
                    <td style="height: 25px;"></td>
                    <td style="height: 25px;"></td>
                    <td style="height: 25px;"></td>
                    <td style="height: 25px;"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>

        <strong>
            SEGUNDO - GARANTIA - </strong> El comprador da la suma de S/. {{ $sale->total }}
        ({{ \App\CoreFacturalo\Helpers\Number\NumberLetter::convertToLetter($sale->total) }}) a
        <strong>CREDIHOGAR</strong> quien declara recibirla a su entera y completa satisfacción, como garantía a cuota
        inicial.
    </p>
    <p>
        <strong>
            @php
                $first_payment = $payment->first();
                $last_payment = $payment->last();
                $first_date_payment = formatDate($first_payment->date_payment);
                $last_date_payment = formatDate($last_payment->date_payment);
            @endphp
            TERCERO - PLAZO DE PAGO -</strong> El comprador abonara en {{ count($payment) }} cuotas comenzando el día
        {{ $first_date_payment }}
        y culminando
        el {{ $last_date_payment }}.
    </p>
    <p>
        <strong>
            CUARTO - PENALIDAD O MOROSIDAD - </strong> En caso de incumplimiento <strong>CREDIHOGAR</strong> tiene la
        facultad de hacer
        uso del
        documento
        firmado por ambas partes “comprador y vendedor” para realizar una demanda y el recojo producto entregado donde
        el
        comprador pierde la garantía dada como cuota inicial sin derecho a reclamo por incumplimiento del contrato en
        agravio a él(la) vendedor(a).
    </p>
    <p>
        <strong>QUINTO - CANCELACIÓN DEL PRODUCTO - CREDIHOGAR</strong>
        está obligado a brindar boleta/factura al momento de la
        cancelación
        del producto.
    </p>


    <p>
        <strong>
            SEXTO -
        </strong>
        Ambas partes señalan y aseguran que en la celebración del mismo no ha mediado error, dado la nulidad que
        pudiera invalidar en contenido del mismo, por lo que proceden a firmar en la provincia de
        PICHANQUI-CHANCHAMAYO-JUNIN.
    </p>

    <table class="mt-2 no-border">
        <tbody>
            <td class="no-border" width="50%">
                <strong>
                    <div>___________________________</div>
                    <div>FIRMA</div>
                    <br>
                    <div>NOMBRE</div>
                    <div>DNI</div>
                    <div>CELULAR</div>
                </strong>
            </td>
            <td class="no-border" width="50%">
                <strong>
                    <div>___________________________</div>
                    <div>FIRMA</div>
                    <br>
                    <div>NOMBRE</div>
                    <div>DNI</div>
                    <div>CELULAR</div>
                </strong>
            </td>
        </tbody>
    </table>
</body>

</html>
