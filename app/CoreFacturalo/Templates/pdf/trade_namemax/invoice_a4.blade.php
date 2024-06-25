@php
    $establishment = $document->establishment;
    $customer = $document->customer;
    $invoice = $document->invoice;
    $document_base = $document->note ? $document->note : null;

    //$path_style =
    // app_path(
    //     'CoreFacturalo' .
    //         DIRECTORY_SEPARATOR .
    //         'Templates' .
    //         DIRECTORY_SEPARATOR .
    //         'pdf' .
    //         DIRECTORY_SEPARATOR .
    //         'style.css',
    // );
    $document_number = $document->series . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $accounts = \App\Models\Tenant\BankAccount::query()->with('bank')->get();
    $hotel_rent = \App\Models\Tenant\HotelRent::where('document_id', $document->id)->first();
    if ($document_base) {
        $affected_document_number = $document_base->affected_document
            ? $document_base->affected_document->series .
                '-' .
                str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT)
            : $document_base->data_affected_document->series .
                '-' .
                str_pad($document_base->data_affected_document->number, 8, '0', STR_PAD_LEFT);
    } else {
        $affected_document_number = null;
    }

    $payments = $document->payments;
    $configuration = \App\Models\Tenant\Configuration::select('show_logo_in_documents')->first();
    $total_payment = $document->payments->sum('payment');
    $balance = $document->total - $total_payment - $document->payments->sum('change');
    if (!function_exists('getUnitType')) {
        function getUnitType($id)
        {
            $unit_type = \App\Models\Tenant\Catalogs\UnitType::find($id);
            return $unit_type && $unit_type->symbol ? $unit_type->symbol : $id;
        }
    }

@endphp
<html>

<head>
    {{-- <title>{{ $document_number }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
</head>
<!-- modelo a4 para la nueva impresion del las boletas y facturas  -->

<body class="margenes" style="position:relative;">
    @if ($document->state_type->id == '11')
        <div class="company_logo_box" style="position: absolute; text-align: center; top:50%;">
            <img src="data:{{ mime_content_type(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png')) }};base64, {{ base64_encode(file_get_contents(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png'))) }}"
                alt="anulado" class="" style="opacity: 0.6;">
        </div>
    @endif
    <table>
        <div
            style=" position: absolute; width: 100%; height: 100%; top: 0%; left: 0%; transform: translate(-50%, -50%); text-align: center;">

            {{-- @if ($company->backgroud_image_document)
                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->backgroud_image_document}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->backgroud_image_document}"))) }}"
                    alt="{{ $company->trade_name }}" style="opacity: 0.5;margin-top:60%">
            @endif --}}
        </div>
    </table>
    <div
        style="
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: space-between;">
        {{-- <div id="contenedor" class="clearfix">
            <div class="border_round text-center" id="lateral">
                <table class="full-width text-center">
                    <tr>
                        <td class="borde">
                            <h3 class="text-center font-bold">{{ 'RUC ' . $company->number }}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="borde">
                            <h5 class="text-center font-bold"><b>{{ $document->document_type->description }}</b></h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="borde">
                            <h3 class="text-center font-bold">{{ $document_number }}</h3>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="principal">
                <table >
                    <tr>
                        @if ($configuration->show_logo_in_documents)
                            @if ($stablishment->logo || $stablishment->document_logo)
                                <td width="100%" height="20px">
                                    <div>
                                        @if ($stablishment->document_logo)
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                >
                                        @else
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                >
                                        @endif
                                    </div>
                                </td>
                            @else
                                @if ($company->logo)
                                    <td width="100%">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <div>
                                                        @if ($company->document_logo)
                                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                                                alt="{{ $company->trade_name }}" 
                                                                style="heigth:50px; width:100px; ">
                                                        @else
                                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                                                alt="{{ $company->trade_name }}" 
                                                                style="heigth:50px; width:100px; ">
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @else
                                    <td width="100%" height="20px">
                                        <img src="{{ asset('logo/logo.jpg') }}" class="company_logo"
                                            style="max-width: 150px">
                                    </td>
                                @endif
                            @endif
                        @else
                        @endif
                        
                    <h5>
                        Don. Fiscal:{{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                        {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                        {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                        {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                    </h5>
                    </tr>

            
                    <tr>
                        <td class="text-center">

                            <h5>{{ $establishment->telephone !== '-' ? 'Cel.:' . $establishment->telephone : '' }} /
                                {{ $establishment->email !== '-' ?  $establishment->email : '' }} </h5>
                            <h6 class="font-bold">{{ $company->eslogan }}</h6>
                            @isset($establishment->web_address)
                                <h5>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                                </h5>
                            @endisset
                        </td>
                    </tr>
                </table>
            </div>
        </div> --}}
        <div style="width: 100%;">
            <div style="width: 60%; float: left;">
                <div style="width: 100%;">
                    @if ($configuration->show_logo_in_documents)
                        @if ($stablishment->logo || $stablishment->document_logo)
                            <div style="width: 100%; height: 20px;">
                                @if ($stablishment->document_logo)
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                        alt="{{ $company->trade_name }}" class="company_logo">
                                @else
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                        alt="{{ $company->trade_name }}" class="company_logo">
                                @endif
                            </div>
                        @else
                            @if ($company->logo)
                                <div style="width: 100%;">
                                    <div style="width: 100%;">
                                        <div>
                                            @if ($company->document_logo)
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" style="height:70px; width:100%; ">
                                            @else
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" style="height:70px; width:100%; ">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div style="width: 100%; height: 20px;">
                                    <img src="{{ asset('logo/logo.jpg') }}" class="company_logo"
                                        style="max-width: 150px">
                                </div>
                            @endif
                        @endif
                    @else
                    @endif

                    {{-- <div>
                        Don. Fiscal:{{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                        {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                        {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                        {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                    </div> --}}

                    <div style="text-align: center;">
                        <div>{{ $establishment->telephone !== '-' ? 'Cel.:' . $establishment->telephone : '' }} /
                            {{ $establishment->email !== '-' ? $establishment->email : '' }} </div>
                        <div class="font-bold">{{ $company->eslogan }}</div>
                        @isset($establishment->web_address)
                            <div>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
            <div style="width: 40%; float: left;">
                <div class="border_round text-center">
                    <table class="full-width text-center">
                        <tr>
                            <td class="borde">
                                <h3 class="text-center font-bold">{{ 'RUC ' . $company->number }}</h3>
                            </td>
                        </tr>
                        <tr>
                            <td class="borde">
                                <h5 class="text-center font-bold"><b>{{ $document->document_type->description }}</b>
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td class="borde">
                                <h3 class="text-center font-bold">{{ $document_number }}</h3>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        {{-- <table>
            <tr>
                <td width="60%">
                    <table>
                        <tr>
                            @if ($configuration->show_logo_in_documents)
                                @if ($stablishment->logo || $stablishment->document_logo)
                                    <td width="100%" height="20px">
                                        <div>
                                            @if ($stablishment->document_logo)
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" class="company_logo">
                                            @else
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" class="company_logo">
                                            @endif
                                        </div>
                                    </td>
                                @else
                                    @if ($company->logo)
                                        <td width="100%">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <div>
                                                            @if ($company->document_logo)
                                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                                                    alt="{{ $company->trade_name }}"
                                                                    style="heigth:50px; width:100px; ">
                                                            @else
                                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                                                    alt="{{ $company->trade_name }}"
                                                                    style="heigth:50px; width:100px; ">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @else
                                        <td width="100%" height="20px">
                                            <img src="{{ asset('logo/logo.jpg') }}" class="company_logo"
                                                style="max-width: 150px">
                                        </td>
                                    @endif
                                @endif
                            @else
                            @endif

                            <h5>
                                Don. Fiscal:{{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                                {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                                {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                                {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                            </h5>
                        </tr>


                        <tr>
                            <td class="text-center">

                                <h5>{{ $establishment->telephone !== '-' ? 'Cel.:' . $establishment->telephone : '' }}
                                    /
                                    {{ $establishment->email !== '-' ? $establishment->email : '' }} </h5>
                                <h6 class="font-bold">{{ $company->eslogan }}</h6>
                                @isset($establishment->web_address)
                                    <h5>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                                    </h5>
                                @endisset
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%">
                    <div class="border_round text-center" id="lateral">
                        <table class="full-width text-center">
                            <tr>
                                <td class="borde">
                                    <h3 class="text-center font-bold">{{ 'RUC ' . $company->number }}</h3>
                                </td>
                            </tr>
                            <tr>
                                <td class="borde">
                                    <h5 class="text-center font-bold">
                                        <b>{{ $document->document_type->description }}</b></h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="borde">
                                    <h3 class="text-center font-bold">{{ $document_number }}</h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table> --}}
        <table>
            <tr>
                <td height="20px" height="20px" >
                    <p><strong>CLIENTE: </strong>{{ $customer->name }} </p>
                </td>
                <td>
                    <p><strong>{{ $customer->identity_document_type->description }} </strong>{{ $customer->number }}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>DIRECCIÓN: </strong>{{ $customer->address }}
                        {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                        {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                        {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                    </p>
                </td>
            </tr>
        </table>

        <div class="mt-3">
            <table class="full-width bordes_impuesto">
                <tr>
                    <td width="120px" height="20px" class="border-top-bottom text-center py-2 bordes  text-center">
                        <b>O. DE COMPRA</b>
                    </td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>FECHA DE EMISIÓN</b></td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>FECHA VCTO.</b></td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>GUIA N°</b></td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>FORMA DE PAGO</b></td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>MONEDA</b></td>
                    <td class="border-top-bottom text-center py-2 bordes  text-center"><b>VENDEDOR</b></td>
                </tr>
                <tr>
                    <td class="text-center">0000-00000</td>
                    <td class="text-center">{{ $document->date_of_issue }} {{ $document->time_of_issue }}</td>
                    <td class="text-center">
                        @isset($invoice->date_of_due)
                            @php
                                $date_of_due = $invoice->date_of_due;
                                $date_of_due = Carbon\Carbon::parse($date_of_due)->format('Y-m-d');
                            @endphp
                            {{ $date_of_due }}
                        @endisset
                    </td>

                    <td class="text-center">
                        @if ($document->guides)

                            @foreach ($document->guides as $guide)
                                @if (isset($guide->document_type_description))
                                @else
                                @endif

                                {{ $guide->number }}
                            @endforeach

                        @endif
                    </td>

                    <td class="text-center">{{ mb_strtoupper($document->payment_condition->name) }}</td>

                    <td class="text-center">{{ mb_strtoupper($document->currency_type->description) }}</td>
                    <td class="text-center">{{ $document->user->name }}</td>

                </tr>
                <tr>
                    @if ($document->detraction)
                        <td width="120px"><b>MÉTODO DE PAGO</b></td>
                        <td width="8px">:</td>
                        <td width="220px">
                            {{ $detractionType->getPaymentMethodTypeDescription($document->detraction->payment_method_id) }}
                        </td>
                    @endif
                </tr>




            </table>
        </div>
        <!-- AQUI ENPIEZA LA TABLA  -->
        <div class=""
            style="min-height: 100vh;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;">
            <table border="0" class="full-width bordes_datos_clientes">
                <thead class="">
                    <tr class="bg-grey">
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            ITEM</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            CODIGO</th>
                        <th class="border-top-bottom text-center py-2 bordes">DESCRIPCIÓN
                        </th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            UNIDAD</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            CANT.</th>



                        <th class="border-top-bottom py-2 bordes  text-center">P.UNIT
                        </th>
                        <th class="border-top-bottom py-2 bordes  text-center">DTO.
                        </th>
                        <th class="border-top-bottom py-2 bordes  text-center">IMPORTE TOTAL
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($document->items as $row)
                        <tr>
                            <td class="text-center font-bold align-top bordes">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-center align-top bordes">
                                {{ $row->item->internal_id }}
                            </td>
                            <td class="text-left align-top bordes">
                                @if (isset($row->name_product_pdf))
                                    {{ $row->name_product_pdf }}
                                @else
                                    @if (isset($row->item->description_internet))
                                        {{ $row->item->description_internet }}
                                    @else
                                        {{ $row->item->description }}
                                    @endif
                                    @if (isset($row->item->has_unit_type))
                                        - {!! $row->item->has_unit_type !!}
                                    @endif
                                    @if (isset($row->item->lots))
                                        @foreach ($row->item->lots as $lot)
                                            <br />{!! $lot->series !!}
                                        @endforeach
                                    @endif
                                    @if (isset($row->item->color_size))
                                        @foreach ($row->item->color_size as $color_size)
                                            <br />{!! '<strong>Color: </strong>' . $color_size->color !!} {!! ' <strong>Talla:</strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ' .
                                                $color_size->size !!} <strong>-
                                                Cant:</strong> {{ $color_size->quantity }}
                                        @endforeach
                                    @endif
                                    @if (isset($row->item->second_name))
                                        - {!! $row->item->second_name !!}
                                    @endif
                                    @if (isset($row->unit_desc))
                                        {!! $row->unit_desc !!}
                                    @endif
                                @endif

                                @if (!empty($row->item->presentation))
                                    {{-- $row->item->presentation->description --}}
                                @endif
                                @if ($row->attributes)
                                    @foreach ($row->attributes as $attr)
                                        <br /><span style="font-size: 9px">{!! $attr->description !!} :
                                            {{ $attr->value }}</span>
                                    @endforeach
                                @endif
                                @if ($row->discounts)
                                    @foreach ($row->discounts as $dtos)
                                        <br /><span style="font-size: 9px">{{ $dtos->factor * 100 }}%
                                            {{ $dtos->description }}</span>
                                    @endforeach
                                @endif

                            </td>
                            <td class="text-center align-top bordes">
                                {{ getUnitType(isset($row->item->has_unit_type) ? 'NIU' : $row->item->unit_type_id) }}
                            </td>
                            <td class="text-center align-top bordes">
                                @if ((int) $row->quantity != $row->quantity)
                                    {{ $row->quantity }}
                                @else
                                    @if (isset($row->unit_qty))
                                        {{ number_format($row->quantity, 0) }}
                                    @else
                                        {{ number_format($row->quantity, 0) }}
                                    @endif
                                @endif
                            </td>

                            <td class="text-center align-top bordes">

                                @if (isset($row->price_unit))
                                    {{ number_format($row->price_unit, 2) }}
                                @else
                                    {{ number_format($row->unit_price, 2) }}
                                @endif

                            </td>
                            <td class="text-center align-top bordes">
                                @if ($row->discounts)
                                    @php
                                        $total_discount_line = 0;
                                        foreach ($row->discounts as $disto) {
                                            $total_discount_line = $total_discount_line + $disto->amount;
                                        }
                                    @endphp
                                    {{ number_format($total_discount_line, 2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td class="text-center align-top bordes">
                                {{ number_format($row->total, 2) }}
                            </td>
                        </tr>
                    @endforeach



                    @if ($document->prepayments)
                        @foreach ($document->prepayments as $p)
                            <tr>
                                <td class="text-center align-top">
                                    1
                                </td>
                                <td class="text-center align-top">NIU</td>
                                <td class="text-left align-top">
                                    ANTICIPO: {{ $p->document_type_id == '02' ? 'FACTURA' : 'BOLETA' }} NRO.
                                    {{ $p->number }}
                                </td>
                                <td class="text-right align-top font-bold">-{{ number_format($p->total, 2) }}
                                </td>
                                <td class="text-right align-top">
                                    0
                                </td>
                                <td class="text-right align-top font-bold">-{{ number_format($p->total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="border-bottom"></td>
                            </tr>
                        @endforeach
                    @endif
                    @php
                        $totalRows =
                            count($document->items) +
                            (isset($document->prepayments) ? count($document->prepayments) : 0);
                        $emptyRows = 18 - $totalRows;
                    @endphp
                    @for ($i = 0; $i < $emptyRows; $i++)
                        <tr class="empty-row">
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                            <td class="text-center align-top bordes desc-14">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <table class="full-width">
            <tr>
                <td colspan="" height="5px"></td>
            </tr>
            <tr>
                <td colspan="2">
                    @foreach (array_reverse((array) $document->legends) as $row)
                        @if ($row->code == '1000')
                            Son: <span class="font-bold">{{ $row->value }}
                                {{ $document->currency_type->description }}</span>
                            @if (count((array) $document->legends) > 1)
                                <p><span class="font-bold">Leyendas</span></p>
                            @endif
                        @else
                            <p> {{ $row->code }}: {{ $row->value }} </p>
                        @endif
                    @endforeach
                    <br />
                    @if ($document->detraction)
                        <p>
                            <span class="font-bold">
                                Operación sujeta al Sistema de Pago de Obligaciones Tributarias
                            </span>
                        </p>
                        <br />
                    @endif
                    @if ($customer->department_id == 16)
                        <br /><br /><br />
                        <div>
                            <center>
                                Representación impresa del Comprobante de Pago Electrónico.
                                <br />Esta puede ser consultada en:
                                <br /><b>{!! url('/buscar') !!}</b>
                                <br /> "Bienes transferidos en la Amazonía
                                <br />para ser consumidos en la misma".
                            </center>
                        </div>
                        <br />
                    @endif

                    {{-- <br>
                    @if (in_array($document->document_type->id, ['01', '03']))
                        @foreach ($accounts as $account)
                            <p><span class="font-bold">{{ $account->bank->description }}</span>
                    {{ $account->currency_type->description }} {{ $account->number }}</p>
                    @endforeach
                    @endif --}}
                </td>
                <td>
                    <table class="table">
                        <tr>
                            <td class="border-top-bottom text-center py-2 bordes  text-left">
                                <strong>Observación:</strong>
                            </td>

                            <td class="border-top-bottom text-center py-2 bordes text-center observation-container"
                                colspan="3">
                                <div class="observation-content">
                                    @foreach ($document->additional_information as $information)
                                        @if ($information)
                                            @if ($loop->first)
                                            @endif
                                            {{ $information }}
                                        @endif
                                    @endforeach
                                    {{ trim($document->observation) }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="full-width" valign="top">
            <tr>
                <td width="70%" valign="top">
                    @if ($company->account_img_trade_name_max)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->account_img_trade_name_max}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->account_img_trade_name_max}"))) }}"
                            alt="{{ $company->trade_name }}" style="width: 500px;height:100px;">
                    @endif
                    <table style="margin-top: 1px;">
                        <tr>
                            <td valign="top">
                                @if ($company->file_nuevo_dolares_img)
                                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->file_nuevo_dolares_img}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->file_nuevo_dolares_img}"))) }}"
                                        alt="{{ $company->trade_name }}" style="width: 315px;height:80px;">
                                @endif
                            </td>
                            <td valign="top" style="text-align: center;">
                                <img src="data:image/png;base64, {{ $document->qr }}"
                                    style="margin-left: 40px; padding: 2px;" width="90px" height="90px" />
                            </td>
                        </tr>
                    </table>
                </td>               
                <td width="30%" valign="top">
                    <table class="full-width bordes_impuesto">
                        @if ($document->total_exportation > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">OP.
                                    EXPORTACIÓN:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center dec">
                                    {{ number_format($document->total_exportation, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_free > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">OP.
                                    GRATUITAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_free, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_unaffected > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">OP.
                                    INAFECTAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_unaffected, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_exonerated > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">OP.
                                    EXONERADAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_exonerated, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_taxed > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">OP.
                                    GRAVADAS:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_taxed, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if ($document->total_discount > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ $document->total_prepayment > 0 ? 'ANTICIPO' : 'DESCUENTO TOTAL' }}:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_discount, 2) }}
                                </td>
                            </tr>
                        @endif

                        @if ($document->total_plastic_bag_taxes > 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">ICBPER:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total_plastic_bag_taxes, 2) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="7" class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                IGV:
                                {{ $document->currency_type->symbol }}
                            </td>
                            <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                {{ number_format($document->total_igv, 2) }}
                            </td>
                        </tr>

                        @if ($document->perception)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12"> IMPORTE
                                    TOTAL:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">PERCEPCIÓN:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->perception->amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12 font-bold">
                                    TOTAL A PAGAR:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center font-20 dsc">
                                    {{ number_format($document->total + $document->perception->amount, 2) }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center font-bold desc-12">
                                    TOTAL A VENTA:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format($document->total, 2) }}
                                </td>
                            </tr>
                            {{-- @if ($document->total_rounded > 0)
                                <tr>
                                    <td colspan="7"
                                        class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                        REDONDEO:
                                        {{ $document->currency_type->symbol }}
                                    </td>
                                    <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                        {{ number_format($document->total_rounded, 2) }}
                                    </td>
                                </tr>
                            @endif --}}
                            @if ($document->total_payment > 0)
                                <tr>
                                    <td colspan="7"
                                        class="border-top-bottom text-center py-2 bordes  text-center desc-12 font-bold">
                                        TOTAL A PAGAR:
                                        {{ $document->currency_type->symbol }}
                                    </td>
                                    <td
                                        class="border-top-bottom text-center py-2 bordes  text-center desc-12 font-bold">
                                        {{ number_format($document->total_payment, 2) }}
                                    </td>
                                </tr>
                            @endif
                        @endif

                        @if ($balance < 0)
                            <tr>
                                <td colspan="7"
                                    class="border-top-bottom text-center py-2 bordes  text-center desc-12">VUELTO:
                                    {{ $document->currency_type->symbol }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-12">
                                    {{ number_format(abs($balance), 2, '.', '') }}
                                </td>
                            </tr>
                        @endif
                    </table>
                    <!-- </div> -->
                </td>
        </table>
    </div>


    <table class="full-width">
        <!-- @if ($document->payment_condition_id == '01')
<tr>
            <td>
                <strong>PAGOS:</strong>
            </td>
        </tr>
        @foreach ($boxes as $box)
<tr>
            <td colspan="4" class="text-left font-bold desc">{{ $box->method }}:
                {{ $document->currency_type->symbol }}
            </td>
            <td class="text-left font-bold desc">{{ number_format(abs($box->amount), 2, '.', '') }}
            </td>
        </tr>
@endforeach
@endif -->
        @if (count($document->fee) > 0)
            <tr>
                <td class="desc pt-5">
                    <strong>CUOTAS:</strong>
                </td>
            </tr>
            @foreach ($document->fee as $key => $quote)
                <tr>
                    <td class="desc">
                        &#8226;
                        {{ empty($quote->getStringPaymentMethodType()) ? 'Cuota #' . ($key + 1) : $quote->getStringPaymentMethodType() }}
                        / Fecha: {{ $quote->date->format('d-m-Y') }} /
                        Monto: {{ $quote->currency_type->symbol }}{{ $quote->amount }}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    @if ($document->user)
        <br>
        <!-- <table class="full-width">
        @php
            $code = null;
            $box = \App\Models\Tenant\Box::where('document_id', $document->id)->first();
            if ($box) {
                $cash = \App\Models\Tenant\Cash::where('id', $box->cash_id)->first();
                if ($cash) {
                    $code = $cash->reference_number;
                }
            }
        @endphp
        @if ($code)
<tr>
            <td>
                <strong>Código A.</strong>: {{ $code }}
            </td>
        </tr>
@endif

            </table> -->
    @endif
</body>

</html>
