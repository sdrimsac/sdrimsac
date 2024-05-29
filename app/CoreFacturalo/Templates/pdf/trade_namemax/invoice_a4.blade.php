@php
    $establishment = $document->establishment;
    $customer = $document->customer;
    $invoice = $document->invoice;
    $document_base = $document->note ? $document->note : null;

    //$path_style =
    app_path(
        'CoreFacturalo' .
            DIRECTORY_SEPARATOR .
            'Templates' .
            DIRECTORY_SEPARATOR .
            'pdf' .
            DIRECTORY_SEPARATOR .
            'style.css',
    );
    $document_number = $document->series . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $accounts = \App\Models\Tenant\BankAccount::all();
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

@endphp
<html>

<head>
    {{-- <title>{{ $document_number }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}
</head>
<!-- modelo a4 para la nueva impresion del las boletas y facturas  -->

<body class="margenes">
    @if ($document->state_type->id == '11')
        <div class="company_logo_box" style="position: absolute; text-align: center; top:50%;">
            <img src="data:{{ mime_content_type(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png')) }};base64, {{ base64_encode(file_get_contents(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png'))) }}"
                alt="anulado" class="" style="opacity: 0.6;">
        </div>
    @endif
    <div>
        <div id="contenedor" class="clearfix">
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
                <table class="logo">
                    <tr>
                        @if ($configuration->show_logo_in_documents)
                            @if ($stablishment->logo || $stablishment->document_logo)
                                <td width="60%" height="20px">
                                    <div>
                                        @if ($stablishment->document_logo)
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                style="max-width: 230px;">
                                        @else
                                            <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                                                alt="{{ $company->trade_name }}" class="company_logo"
                                                style="max-width: 230px;">
                                        @endif
                                    </div>
                                </td>
                            @else
                                @if ($company->logo)
                                    <td width="60%" height="20px">
                                        <div>
                                            @if ($company->document_logo)
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" class="company_logo"
                                                    style="max-width: 230px;">
                                            @else
                                                <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                                                    alt="{{ $company->trade_name }}" class="company_logo"
                                                    style="max-width: 230px;">
                                            @endif
                                        </div>
                                    </td>
                                @else
                                    <td width="60%" height="20px">
                                        <img src="{{ asset('logo/logo.jpg') }}" class="company_logo"
                                            style="max-width: 150px">
                                    </td>
                                @endif
                            @endif
                        @else
                        @endif
                    </tr>
                    <!-- <tr> -->
                    <!-- <td width="60%" class="align-top" height="20px">
                            <div class="text-center">
                                 <h4 class=""><b>{{ $company->trade_name }}</b></h4> -->
                    <!-- <h6>{{ $company->eslogan }}</h6> -->
                    <!-- @isset($establishment->aditional_information)
    <h5><b>{{ $establishment->aditional_information !== '-' ? $establishment->aditional_information : '' }}</b>
                                                    </h5>
@endisset -->
                    <!-- <h5>
                                    {{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                                    {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                                    {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                                    {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                                </h5> -->
                    <!-- @isset($establishment->trade_address)
    <h5>{{ $establishment->trade_address !== '-' ? '  ' . $establishment->trade_address : '' }}
                                                    </h5>
@endisset -->
                    <!-- <h5>{{ $establishment->telephone !== '-' ? 'Teléfono:' . $establishment->telephone : '' }}
                                </h5> -->
                    <!-- <h5>{{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }}
                                </h5> -->
                    <!--  @isset($establishment->web_address)
    <h5>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                                                    </h5>
@endisset
                            </div>
                        </td> -->
                    <!-- </tr> -->
                    <tr>
                        <td class="text-center">
                            <!-- @isset($establishment->trade_address)
    <h5>{{ $establishment->trade_address !== '-' ? '  ' . $establishment->trade_address : '' }}
                                                    </h5>
@endisset -->
                            <h5>
                                Don. Fiscal:{{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                                {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                                {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                                {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
                            </h5>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">

                            <h5>{{ $establishment->telephone !== '-' ? 'Cel.:' . $establishment->telephone : '' }} /
                                {{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }} </h5>
                            <!-- <h5>{{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }}</h5> -->
                            <h6 class="font-bold">{{ $company->eslogan }}</h6>
                            @isset($establishment->web_address)
                                <h5>{{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}
                                </h5>
                            @endisset
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <table>
            <tr>
                <td height="20px" height="20px" class="font-bold">
                    <p><strong>CLIENTE: </strong>{{ $customer->name }} </p>
                </td>
                <td class="font-bold">
                    <p><strong>{{ $customer->identity_document_type->description }} </strong>{{ $customer->number }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="font-bold">
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

                    <td class="text-center">{{ $document->currency_type_id }}</td>
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

                <!--  @isset($customer->telephone)
    <tr>
                                        <td height="20px"><b>TELEFONO</b></td>
                                        <td height="20px">:</td>
                                        <td height="20px">{{ $customer->telephone }}</td>
                                        <td height="20px"></td>
                                        <td height="20px"></td>
                                        <td height="20px"></td>

                                    </tr>
@endisset -->


                <!-- @if (isset($students) && count($students) > 0)
@foreach ($students as $student)
<tr>
                    <td height="20px"><b>ALUMNO</b></td>
                    <td height="20px">:</td>
                    <td height="20px">{{ $student['name'] }}</td>
                    <td height="20px"><b>CLASE</b></td>
                    <td height="20px">:</td>
                    <td height="20px">
                        {{ isset($student['class']) ? $student['class'] : '' }}
                    </td>

                </tr>
@endforeach
@endif -->
                <!-- <tr>


                    @if ($document->detraction)
<td width="120px" height="20px"><b>P. DETRACCIÓN</b></td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->detraction->percentage }}%</td>
@endif
                </tr> -->
                <!-- @if ($customer->address !== '')
<tr>
                    <td class="align-top" height="20px"><b>DIRECCIÓN:</b></td>
                    <td>:</td>
                    <td colspan="4">
                        {{ $customer->address }}
                        {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                        {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                        {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                    </td>
                    @if ($document->detraction)
<td width="120px" height="20px">MONTO DETRACCIÓN</td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->currency_type->symbol }} {{ $document->detraction->amount }}</td>
@endif
                </tr> -->
                <!--
@endif

                @if ($document->detraction)
@if ($document->detraction->pay_constancy)
<tr>
                    <td colspan="3">
                    </td>
                    <td width="120px" height="20px">CONSTANCIA DE PAGO</td>
                    <td width="8px" height="20px">:</td>
                    <td>{{ $document->detraction->pay_constancy }}</td>
                </tr>
@endif
@endif -->
            </table>
        </div>


        <!-- @if ($document->guides)
<br />
        {{-- <strong>Guías:</strong> --}}
        <table>
            @foreach ($document->guides as $guide)
<tr>
                @if (isset($guide->document_type_description))
<td height="20px">{{ $guide->document_type_description }}</td>
@else
<td height="20px">{{ $guide->document_type_id }}</td>
@endif
                <td height="20px">:</td>
                <td height="20px">{{ $guide->number }}</td>
            </tr>
@endforeach
        </table> -->
        <!--
@endif
        @if ($hotel_rent)
@php
    $hotel_rent_items = $hotel_rent->items;

@endphp -->
        <!-- <table>
            @foreach ($hotel_rent_items as $hri)
<tr>
                <td height="18px">
                    <b>
                        Habitación:
                    </b>
                </td>
                <td colspan="3" class="align-top">
                    {{ $hri->table->number }}
                </td>
            </tr>
            <tr>
                <td height="18px">
                    <b>
                        Entrada:
                    </b>

                </td>
                <td colspan="3" class="align-top">

                    {{ \Carbon\Carbon::parse($hri->checkin_date)->format('d/m/Y') }} {{ $hri->checkin_time }}
                </td>
            </tr>
            <tr>
                <td height="18px">
                    <b>
                        Salida:
                    </b>

                </td>
                <td colspan="3" class="align-top">
                    {{ \Carbon\Carbon::parse($hri->checkout_date)->format('d/m/Y') }}
                    {{ $hri->checkout_time }}
                </td>
            </tr>
@endforeach
        </table>
@endif -->

        <!-- AGREGADO PARA NUEVOS CAMBIOS  -->
        <!-- <td width="60%" class="align-top" height="20px">
            <div class="text-left">
                <h4 class=""><b>{{ $company->trade_name }}</b></h4>
                <h6>{{ $company->eslogan }}</h6>
            </div>
        </td>

        @if ($customer->address !== '')
<tr>
            <td class="align-top" height="20px"><b>DIRECCIÓN:</b></td>
            <td>:</td>
            <td colspan="4">
                {{ $customer->address }}
                {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
            </td>
            @if ($document->detraction)
<td width="120px" height="20px">MONTO DETRACCIÓN</td>
            <td width="8px" height="20px">:</td>
            <td>{{ $document->currency_type->symbol }} {{ $document->detraction->amount }}</td>
@endif
        </tr>
@endif -->

        <!-- <div class="mt-2">
            <strong>Observación:</strong>
            @foreach ($document->additional_information as $information)
@if ($information)
@if ($loop->first)
@endif
            {{ $information }}
@endif
@endforeach
            {{ trim($document->observation) }}
        </div> -->


        <!-- <table class="full-width mt-3">
            @if ($document->prepayments)
@foreach ($document->prepayments as $p)
<tr>
                <td width="120px" height="20px">ANTICIPO</td>
                <td width="8px" height="20px">:</td>
                <td>{{ $p->number }}</td>
            </tr>
@endforeach
@endif
            @if ($document->purchase_order)
<tr>
                <td width="120px" height="20px">ORDEN DE COMPRA</td>
                <td width="8px" height="20px">:</td>
                <td>{{ $document->purchase_order }}</td>
            </tr>
@endif
            @isset($document->quotation->sale_opportunity)
    <tr>
                                    <td width="120px" height="20px">O. VENTA</td>
                                    <td width="8px" height="20px">:</td>
                                    <td>{{ $document->quotation->sale_opportunity->number_full }}</td>
                                </tr>
@endisset
            @if (!is_null($document_base))
<tr>
                <td width="120px" height="20px">DOC. AFECTADO</td>
                <td width="8px" height="20px">:</td>
                <td height="20px">{{ $affected_document_number }}</td>
            </tr>
            <tr>
                <td height="20px">TIPO DE NOTA</td>
                <td height="20px">:</td>
                <td height="20px">
                    {{ $document_base->note_type === 'credit' ? $document_base->note_credit_type->description : $document_base->note_debit_type->description }}
                </td>
            </tr>
            <tr>
                <td height="20px" height="20px">DESCRIPCIÓN</td>
                <td height="20px">:</td>
                <td height="20px">{{ $document_base->note_description }}</td>
            </tr>
@endif
        </table> -->

        <!-- {{-- <table class="full-width mt-3"> --}}
        {{-- <tr> --}}
        {{-- <td width="25%">Documento Afectado:</td> --}}
        {{-- <td width="20%">{{ $document_base->affected_document->series }}-{{ $document_base->affected_document->number }}
        </td> --}}
        {{-- <td width="15%">Tipo de nota:</td> --}}
        {{-- <td width="40%">{{ ($document_base->note_type === 'credit')?$document_base->note_credit_type->description:$document_base->note_debit_type->description}}
        </td> --}}
        {{-- </tr> --}}
        {{-- <tr> --}}
        {{-- <td class="align-top">Descripción:</td> --}}
        {{-- <td class="text-left" colspan="3">{{ $document_base->note_description }}</td> --}}
        {{-- </tr> --}}
        {{-- </table> --}} -->


        <!-- AQUI ENPIEZA LA TABLA  -->
        <div class="">
            <table border="0" class="full-width bordes_datos_clientes">
                <thead class="">
                    <tr class="bg-grey">
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            ITEM</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            CANT.</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            UNIDAD</th>
                        <th class="border-top-bottom text-center py-2 bordes  text-center">
                            CODIGO</th>
                        <th class="border-top-bottom text-center py-2 bordes">DESCRIPCIÓN
                        </th>
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
                                {{ isset($row->item->has_unit_type) ? 'NIU' : $row->item->unit_type_id }}
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

                                {{-- @if ($row->item->is_set == 1)
                                    <br>
                                    @inject('itemSet', 'App\Services\ItemSetService')
                                    {{ join('-', $itemSet->getItemsSet($row->item_id)) }}
                            @endif --}}
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
                <td width="70%">
                    <table class="full-width bordes_impuesto">

                        {{-- <tr>
                            <td class="border-top-bottom text-center py-2 bordes  text-center desc-11" width="14px"
                                height="20px">
                                EMPRESA
                            </td>
                            <td class="border-top-bottom text-center py-2 bordes  text-center font-bold"
                                width="14px" height="20px">
                                {{ $company->trade_name }}
                            </td>
                            <td></td>
                        </tr> --}}
                        @php
                            $has_last_empty_bank = false;
                            $currencies = array_map(function ($bank) {
                                return $bank['currency_type_id'];
                            }, $accounts->toArray());
                            $currencies_unique = array_unique($currencies);
                            $bank_array = $accounts->toArray();
                            $all_banks = [];
                            foreach ($currencies_unique as $currency) {
                                $tmp = array_filter($bank_array, function ($bk) use ($currency) {
                                    return $bk['currency_type_id'] == $currency;
                                });

                                $all_banks[] = $tmp;
                            }
                            $last_key = array_key_last($all_banks);
                            $count_key = count($all_banks[$last_key]);
                            $has_last_empty_bank = $count_key % 2 !== 0;
                        @endphp

                        @foreach ($all_banks as $idxg => $current_currency)
                            @php
                                dump($idxg. " el idx");
                                dump($last_key. " el last");
                                $chunks = array_chunk($current_currency, 2);
                            @endphp
                            {{-- $last_key_chunk = array_key_last($current_currency); --}}
                            @foreach ($chunks as $idx => $account_currency)
                                @php
                                    $currency_type =
                                        $account_currency[0]['currency_type_id'] == 'PEN' ? 'SOLES' : 'DOLARES';
                                    $isLastChunk = $idx === count($chunks) - 1;
                                    $chunkSize = count($account_currency);
                                @endphp
                                <tr>
                                    <td colspan="3">
                                        <table class="full-width">
                                            <tr>
                                                <td width="130px"
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    BANCO</td>
                                                <td width="200px"
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    {{ $account_currency[0]['description'] }} - {{$last_key}} - {{$idxg}}
                                                </td>


                                                @if ($isLastChunk && $chunkSize == 1 &&  $last_key == $idxg)
                                                    <td rowspan="3"
                                                        class="font-sm border-top-bottom text-center py-2 bordes  text-left">

                                                    </td>
                                                @else
                                                    <td
                                                        class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                        @isset($account_currency[1])
                                                            {{ $account_currency[1]['description'] }} - {{$last_key}} - {{$idxg}}
                                                        @endisset
                                                    </td>
                                                @endif


                                            </tr>
                                            <tr>
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    CTA CTE {{ $currency_type }} </td>
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    {{ $account_currency[0]['number'] }}
                                                </td>
                                                @if (!$isLastChunk && $chunkSize !== 1 &&  $last_key !== $idxg)
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    @isset($account_currency[1])
                                                        {{ $account_currency[1]['number'] }}
                                                    @endisset
                                                </td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    CTA CTE {{ $currency_type }} CCI</td>
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    {{ $account_currency[0]['cci'] }}
                                                </td>
                                                @if (!$isLastChunk && $chunkSize !== 1 && $last_key !== $idxg)
                                                <td
                                                    class="font-sm border-top-bottom text-center py-2 bordes  text-left">
                                                    @isset($account_currency[1])
                                                        {{ $account_currency[1]['cci'] }}
                                                    @endisset
                                                </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                        {{-- @foreach ($accounts as $account)
                            <tr>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-11"
                                    width="14px" height="20px">BANCO:</td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center font-bold background-color: blue;"
                                    width="14px" height="20px">{{ $account->description }}</td>
                            </tr>
                            <tr>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-11"
                                    width="14px" height="20px">CTA CTE EN {{ $account->currency_type_id }} </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center font-bold"
                                    width="14px" height="20px"> {{ $account->number }}</td>
                            </tr>
                            <tr>
                                <td class="border-top-bottom text-center py-2 bordes  text-center desc-11"
                                    width="14px" height="20px">CTA CTE CCI EN {{ $account->currency_type_id }}
                                </td>
                                <td class="border-top-bottom text-center py-2 bordes  text-center font-bold"
                                    width="14px" height="20px">{{ $account->cci }}</td>
                            </tr>
                        @endforeach --}}
                    </table>
                </td>
                {{-- <td>
                    <img src="data:image/png;base64, {{ $document->qr }}"
                        style="margin-right: -10px; padding: 10px;" width="90px" height="90px" /> --}}
                <!-- <table>
                        <tr>
                            <td width="30%" class="text-center">
                                <img src="data:image/png;base64, {{ $document->qr }}" style="margin-right: -10px;" />
                        <!--<p style="font-size: 9px">Código Hash: {{ $document->hash }}</p>
                        </td>
                    </tr>
                    </table> -->
                {{-- </td> --}}

                <td width="30%" valign="top">
                    <!-- <div class="bordes_datos_clientes "> -->
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
                            @if ($document->total_rounded > 0)
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
                            @endif
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
            <tr>
                <!-- <tr>
                        <td width="30%">
                        <img src="data:image/png;base64, {{ $document->qr }}" style="margin-right: -10px;" />
                        <p style="font-size: 9px">Código Hash: {{ $document->hash }}</p>
                        </td>
                    </tr> -->
            </tr>
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
