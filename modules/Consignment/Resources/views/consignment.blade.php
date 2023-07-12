@php
    
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    
    $tittle = 'Consignación';
    
@endphp
<html>

<head>
    {{-- <title>{{ $tittle }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
    <style>
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .font-md {
            font-size: 12px;
        }

        .font-lg {
            font-size: 14px;
        }

        .font-xlg {
            font-size: 16px;
        }

        .font-bold {
            font-weight: bold;
        }

        .company_logo {
            max-height: 100px;
        }

        .company_logo_box {
            text-align: center;
            width: 100%;
        }

        .company_logo_ticket {
            max-width: 200px;
            max-height: 80px
        }

        .contain {
            object-fit: cover;
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

        .align-top {
            vertical-align: top !important;
        }

        .full-width {
            width: 100%;
        }

        .bordes_datos_clientes {
            border: thin solid #333 !important;
            border-radius: 10px;
            padding: 5px;
        }

        .bordes {
            border: thin solid #333 !important;
        }

        .border_detalles {
            border-bottom: thin solid #333 !important;

        }

        #contenedor {
            text-align: left;
            width: 100%;
            margin: auto;
        }

        #lateral {
            width: 28%;
            /* Este será el ancho que tendrá tu columna */
            background-color: #FFF;
            /* Aquí pon el color del fondo que quieras para este lateral */
            float: right;
            /* Aquí determinas de lado quieres quede esta "columna" */
        }

        #lateral_sales {
            width: 27%;
            /* Este será el ancho que tendrá tu columna */
            background-color: #FFF;
            /* Aquí pon el color del fondo que quieras para este lateral */
            float: right;
            /* Aquí determinas de lado quieres quede esta "columna" */
        }

        #principal {
            width: 70%;
            float: left;
            background-color: #FFFFFF;

        }

        /* Para limpiar los floats */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        .border_round {
            border: thin solid #333 !important;
            border-radius: 10px !important;
            padding: 5px;
        }

        .bordes_impuesto {
            border: thin solid #333 !important;
        }

        .m-10 {
            margin: 10px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .m-20 {
            margin: 20px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .p-20 {
            padding: 20px;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .pb-20 {
            padding-bottom: 20px;
        }

        .p-10 {
            padding: 10px;
        }

        .pt-10 {
            padding-top: 10px;
        }

        .pb-10 {
            padding-bottom: 10px;
        }

        .border-box {
            border: thin solid #333;
        }

        .border-top {
            border-top: thin solid #333;
        }

        .border-bottom {
            border-bottom: thin solid #333;
        }

        .border-top-bottom {
            border-top: thin solid #333;
            border-bottom: thin solid #333;
        }

        .bg-grey {
            background-color: #F8F8F8;
            font-size: 11px !important;
        }

        .logo {}

        /* Headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 200;
            letter-spacing: -1px;
            margin: 0 !important;
            padding: 0 !important;
        }

        h1 {
            font-size: 32px;
            line-height: 44px;
            font-weight: 400;
        }

        h2 {
            font-size: 24px;
            /* font-weight: 500; */
            line-height: 42px;
        }

        h3 {
            font-size: 18px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 24px;
        }

        h4 {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 27px;
        }

        h5 {
            font-size: 13px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 18px;
        }

        h6 {
            font-size: 10px;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 18px;
        }

        table,
        tr,
        td,
        th {
            font-size: 11px !important;
        }

        p {
            font-size: 12px !important;
        }

        .desc {
            font-size: 10px !important;
        }

        .desc-9 {
            font-size: 9px !important;
        }


        .m-0 {
            margin: 0 !important;
        }

        .mt-0,
        .my-0 {
            margin-top: 0 !important;
        }

        .mr-0,
        .mx-0 {
            margin-right: 0 !important;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .ml-0,
        .mx-0 {
            margin-left: 0 !important;
        }

        .m-1 {
            margin: 0.25rem !important;
        }

        .mt-1,
        .my-1 {
            margin-top: 0.25rem !important;
        }

        .mr-1,
        .mx-1 {
            margin-right: 0.25rem !important;
        }

        .mb-1,
        .my-1 {
            margin-bottom: 0.25rem !important;
        }

        .ml-1,
        .mx-1 {
            margin-left: 0.25rem !important;
        }

        .m-2 {
            margin: 0.5rem !important;
        }

        .mt-2,
        .my-2 {
            margin-top: 0.5rem !important;
        }

        .mr-2,
        .mx-2 {
            margin-right: 0.5rem !important;
        }

        .mb-2,
        .my-2 {
            margin-bottom: 0.5rem !important;
        }

        .ml-2,
        .mx-2 {
            margin-left: 0.5rem !important;
        }

        .m-3 {
            margin: 1rem !important;
        }

        .mt-3,
        .my-3 {
            margin-top: 1rem !important;
        }

        .mr-3,
        .mx-3 {
            margin-right: 1rem !important;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .ml-3,
        .mx-3 {
            margin-left: 1rem !important;
        }

        .m-4 {
            margin: 1.5rem !important;
        }

        .mt-4,
        .my-4 {
            margin-top: 1.5rem !important;
        }

        .mr-4,
        .mx-4 {
            margin-right: 1.5rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        .ml-4,
        .mx-4 {
            margin-left: 1.5rem !important;
        }

        .m-5 {
            margin: 3rem !important;
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem !important;
        }

        .mr-5,
        .mx-5 {
            margin-right: 3rem !important;
        }

        .mb-5,
        .my-5 {
            margin-bottom: 3rem !important;
        }

        .ml-5,
        .mx-5 {
            margin-left: 3rem !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .pt-0,
        .py-0 {
            padding-top: 0 !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pb-0,
        .py-0 {
            padding-bottom: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .p-1 {
            padding: 0.25rem !important;
        }

        .pt-1,
        .py-1 {
            padding-top: 0.25rem !important;
        }

        .pr-1,
        .px-1 {
            padding-right: 0.25rem !important;
        }

        .pb-1,
        .py-1 {
            padding-bottom: 0.25rem !important;
        }

        .pl-1,
        .px-1 {
            padding-left: 0.25rem !important;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .pt-2,
        .py-2 {
            padding-top: 0.5rem !important;
        }

        .pr-2,
        .px-2 {
            padding-right: 0.5rem !important;
        }

        .pb-2,
        .py-2 {
            padding-bottom: 0.5rem !important;
        }

        .pl-2,
        .px-2 {
            padding-left: 0.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .pt-3,
        .py-3 {
            padding-top: 1rem !important;
        }

        .pr-3,
        .px-3 {
            padding-right: 1rem !important;
        }

        .pb-3,
        .py-3 {
            padding-bottom: 1rem !important;
        }

        .pl-3,
        .px-3 {
            padding-left: 1rem !important;
        }

        .p-4 {
            padding: 1.5rem !important;
        }

        .pt-4,
        .py-4 {
            padding-top: 1.5rem !important;
        }

        .pr-4,
        .px-4 {
            padding-right: 1.5rem !important;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 1.5rem !important;
        }

        .pl-4,
        .px-4 {
            padding-left: 1.5rem !important;
        }

        .p-5 {
            padding: 3rem !important;
        }

        .pt-5,
        .py-5 {
            padding-top: 3rem !important;
        }

        .pr-5,
        .px-5 {
            padding-right: 3rem !important;
        }

        .pb-5,
        .py-5 {
            padding-bottom: 3rem !important;
        }

        .pl-5,
        .px-5 {
            padding-left: 3rem !important;
        }

        .m-n1 {
            margin: -0.25rem !important;
        }

        .mt-n1,
        .my-n1 {
            margin-top: -0.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -0.25rem !important;
        }

        .mb-n1,
        .my-n1 {
            margin-bottom: -0.25rem !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -0.25rem !important;
        }

        .m-n2 {
            margin: -0.5rem !important;
        }

        .mt-n2,
        .my-n2 {
            margin-top: -0.5rem !important;
        }

        .mr-n2,
        .mx-n2 {
            margin-right: -0.5rem !important;
        }

        .mb-n2,
        .my-n2 {
            margin-bottom: -0.5rem !important;
        }

        .ml-n2,
        .mx-n2 {
            margin-left: -0.5rem !important;
        }

        .m-n3 {
            margin: -1rem !important;
        }

        .mt-n3,
        .my-n3 {
            margin-top: -1rem !important;
        }

        .mr-n3,
        .mx-n3 {
            margin-right: -1rem !important;
        }

        .mb-n3,
        .my-n3 {
            margin-bottom: -1rem !important;
        }

        .ml-n3,
        .mx-n3 {
            margin-left: -1rem !important;
        }

        .m-n4 {
            margin: -1.5rem !important;
        }

        .mt-n4,
        .my-n4 {
            margin-top: -1.5rem !important;
        }

        .mr-n4,
        .mx-n4 {
            margin-right: -1.5rem !important;
        }

        .mb-n4,
        .my-n4 {
            margin-bottom: -1.5rem !important;
        }

        .ml-n4,
        .mx-n4 {
            margin-left: -1.5rem !important;
        }

        .m-n5 {
            margin: -3rem !important;
        }

        .mt-n5,
        .my-n5 {
            margin-top: -3rem !important;
        }

        .mr-n5,
        .mx-n5 {
            margin-right: -3rem !important;
        }

        .mb-n5,
        .my-n5 {
            margin-bottom: -3rem !important;
        }

        .ml-n5,
        .mx-n5 {
            margin-left: -3rem !important;
        }

        .m-auto {
            margin: auto !important;
        }

        .mt-auto,
        .my-auto {
            margin-top: auto !important;
        }

        .mr-auto,
        .mx-auto {
            margin-right: auto !important;
        }

        .mb-auto,
        .my-auto {
            margin-bottom: auto !important;
        }

        .ml-auto,
        .mx-auto {
            margin-left: auto !important;
        }
    </style>
</head>

<body>
    <table class="full-width">
        <tr>
            @if ($company->logo)
                <td width="20%">
                    <div class="company_logo_box">
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->name }}" class="company_logo" style="max-width: 150px;">
                    </div>
                </td>
            @else
                <td width="20%">
                </td>
            @endif
            <td width="50%" class="pl-3">
                <div class="text-left">
                    <h4 class="">{{ $company->trade_name }}</h4>
                    <h6>{{ $company->eslogan }}</h6>
                    <h5>{{ 'RUC ' . $company->number }}</h5>
                    <h6>
                        {{ $establishment->address !== '-' ? $establishment->address : '' }}
                        {{ $establishment->district_id !== '-' ? ', ' . $establishment->district->description : '' }}
                        {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                        {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                    </h6>
                    <h6>{{ $establishment->email !== '-' ? $establishment->email : '' }}</h6>
                    <h6>{{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}</h6>
                </div>
            </td>
            <td width="30%" class=" border-box py-2 px-2 text-center">
                @php
                    $number = str_pad($consignment->id, 8, '0', STR_PAD_LEFT);
                @endphp
                <h5 class="text-center">CONSIGNACION</h5>
                <h3 class="text-center">{{ $number }}</h3>

            </td>
        </tr>
    </table>
    <table class="full-width mt-4">
        <tr>
            <td width="80" height="18px"><b>Cliente:</b></td>
            <td>{{ $customer->name }}</td>
            <td><b>{{ $customer->identity_document_type->description }}:</b></td>
            <td>{{ $customer->number }}</td>

        </tr>

        <tr>
            <td height="18px"><b>Telefono:</b></td>
            <td>{{ $customer->telephone }}</td>
            {{-- <td><b>Fecha Emisión</b></td>
            <td>{{ \Carbon\Carbon::parse($consignment->date_of_issue)->format('d-m-Y') }}</td> --}}

        </tr>
        @if ($customer->address !== '')
            <tr>
                <td height="18px"><b>Dirección:</b></td>
                <td colspan="3">
                    {{ $customer->address }}
                    {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                    {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                    {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                </td>
            </tr>
        @endif
        <tr>

            <td><b>Fecha Emisión:</b></td>
            <td>{{ \Carbon\Carbon::parse($consignment->date_of_issue)->format('d-m-Y') }}</td>
            <td><b>Fecha de liquidación:</b></td>
            <td>{{ \Carbon\Carbon::parse($consignment->date_of_end)->format('d-m-Y') }}</td>
        </tr>


        {{-- @if ($consignment->liquidated == 1)
            <tr>
                <td height="18px"><b>Estado:</b></td>
                <td colspan="3">LIQUIDADO</td>
            </tr>
        @else
            <tr>
                <td height="18px"><b>Estado:</b></td>
                <td colspan="3">POR LIQUIDAR</td>
            </tr>
        @endif --}}
        {{-- <tr>
        <td  height="18px"><b>OBSERVACION:</b></td>
        <td colspan="3" class="align-top" >{{trim($document->additional_information)}}</td>
    </tr> --}}
    </table>

    <table class="full-width mt-10 mb-10">
        <thead class="">
            <tr class="bg-grey">
                <th class="border-top-bottom text-center py-2" width="8%">CANT.</th>
                <th class="border-top-bottom text-center py-2" width="8%">UNIDAD</th>
                <th class="border-top-bottom text-left py-2">DESCRIPCIÓN</th>
                <th class="border-top-bottom text-right py-2" width="12%">P.UNIT</th>
                <th class="border-top-bottom text-right py-2" width="12%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td class="text-center">
                        {{ $item->original_quantity }}
                    </td>
                    <td class="text-center">
                        {{ $item->item->unit_type_id }}
                    </td>
                    <td>
                        {{ $item->item->description }}
                    </td>
                    <td class="text-right">
                        {{ $item->price }}
                    </td>
                    <td class="text-right">
                        {{ $item->price * $item->original_quantity }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table align="center" width="70%" style="margin-top:50px">
        @if ($consignment->penalty)
            <tr>
                <td align="center">
                    <small>
                        {{-- Un anunció sobre la penalidad --}}
                        @php
                            $penalty = $consignment->penalty;
                            $type = $consignment->type;
                            $description = $type == 'fixed' ? 'de S/. ' . $penalty->amount : 'del ' . $penalty->amount . '%';
                        @endphp
                        La consignación tiene una penalidad {{ $description }}, si se vence la fecha de liquidación.
                    </small>
                </td>
            </tr>
        @endif
        {{-- <tr>
            <td align="center" width="45%" style="border-top:1px solid #000;font-weight:bold">Recibi
                Conforme<br>Cliente</td>
            <td></td>
            <td align="center" width="45%" style="border-top:1px solid #000;font-weight:bold">Vendedor: {{ $document->user->name }}<br>Celular:{{ $document->user->telephone }}</td>

        </tr> --}}
    </table>
</body>

</html>
