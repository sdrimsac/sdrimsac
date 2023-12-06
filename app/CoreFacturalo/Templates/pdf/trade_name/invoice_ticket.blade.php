@php
    $establishment = $document->establishment;
    $customer = $document->customer;
    $invoice = $document->invoice;
    $establish_model = \App\Models\Tenant\Establishment::where('id', $document->establishment_id)->first();
    $conf_establishment = \App\Models\Tenant\ConfEstablishment::where('establishment_id', $document->establishment_id)->first();
    $print_company_address = false;
    if ($conf_establishment) {
        $print_company_address = $conf_establishment->company_address;
    }
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
    $document_number = $document->series . '-' . str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $accounts = \App\Models\Tenant\BankAccount::all();
    $document_base = $document->note ? $document->note : null;
    $payments = $document->payments;
    $paymet2 = $document->payment;
    
    $is_chifa_china = $company->number == '15609876309';
    if ($document_base) {
        $affected_document_number = $document_base->affected_document ? $document_base->affected_document->series . '-' . str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT) : $document_base->data_affected_document->series . '-' . str_pad($document_base->data_affected_document->number, 8, '0', STR_PAD_LEFT);
    } else {
        $affected_document_number = null;
    }
    
    $total_payment = $document->payments->sum('payment');
    //$balance = ($document->total - $total_payment) - $document->payments->sum('change');
    $balance = -5;
    $hotel_rent = \App\Models\Tenant\HotelRent::where('document_id', $document->id)->first();
    $hotel_rent_advance = \App\Models\Tenant\HotelRentDocument::where('document_id', $document->id)->first();
@endphp
<html>

<head>
    {{-- <title>{{ $document_number }}</title> --}}
    {{-- <link href="{{ $path_style }}" rel="stylesheet" /> --}}

</head>

<body>

    @if ($stablishment->logo || $stablishment->document_logo)
        @if ($is_chifa_china)
            <div class="text-center company_logo_box" style="padding-top:2rem;width: 350px;">
                @if ($stablishment->document_logo)
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="
    contain" style=" max-width: 400px;max-height: 150px">
                @else
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="
    contain" style=" max-width: 400px;max-height: 150px">
                @endif
            </div>
        @else
            <div class="text-center company_logo_box pt-5 pl-5">
                @if ($stablishment->document_logo)
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->document_logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                @else
                    <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$stablishment->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$stablishment->logo}"))) }}"
                        alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                @endif
            </div>
        @endif
    @else
        @if ($company->logo)
            @if ($is_chifa_china)
                <div class="text-center company_logo_box" style="padding-top:2rem;width: 350px;">
                    @if ($company->document_logo)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
        contain"
                            style=" max-width: 400px;max-height: 150px">
                    @else
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="
        contain"
                            style=" max-width: 400px;max-height: 150px">
                    @endif
                </div>
            @else
                <div class="text-center company_logo_box pt-5 pl-5">
                    @if ($company->document_logo)
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->document_logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->document_logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                    @else
                        <img src="data:{{ mime_content_type(public_path("storage/uploads/logos/{$company->logo}")) }};base64, {{ base64_encode(file_get_contents(public_path("storage/uploads/logos/{$company->logo}"))) }}"
                            alt="{{ $company->trade_name }}" class="company_logo_ticket contain">
                    @endif
                </div>
            @endif
        @endif
    @endif

    @if ($document->state_type->id == '11')
        <div class="company_logo_box" style="position: absolute; text-align: center; top:500px">
            <img src="data:{{ mime_content_type(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png')) }};base64, {{ base64_encode(file_get_contents(public_path('status_images' . DIRECTORY_SEPARATOR . 'anulado.png'))) }}"
                alt="anulado" class="" style="opacity: 0.6;">
        </div>
    @endif
    <table class="full-width" style="margin-left:15px;margin-right:15px;">
        <tr>

            <td class="text-center">
                @if ($is_chifa_china)
                    <h1>{{ $company->trade_name }}</h1>
                @else
                    <h4>{{ $company->trade_name }}</h4>
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center">
                @if ($is_chifa_china)
                    <h5>{{ $company->eslogan }}</h5>
                @else
                    <h4>{{ $company->eslogan }}</h4>
                @endif
            </td>
        </tr>
        @if ($is_chifa_china)
            <tr>
                <td class="text-center">


                    <h5> {{ $company->name }}</h5>
                </td>
            </tr>
        @endif
        <tr>
            <td class="text-center">
                @if ($is_chifa_china)
                    <h5>{{ 'RUC ' . $company->number }}</h5>
                @else
                    <h5>{{ 'RUC ' . $company->number }}</h5>
            </td>
            @endif
        </tr>


        <tr>
            <td class="text-center">
                {{ $establishment->address !== '-' ? $establishment->address . ',' : '' }}
                {{ $establishment->district_id !== '-' ? '' . $establishment->district->description : '' }}
                {{ $establishment->province_id !== '-' ? ', ' . $establishment->province->description : '' }}
                {{ $establishment->department_id !== '-' ? '- ' . $establishment->department->description : '' }}
            </td>
        </tr>
        @if ($print_company_address)
            @isset($establish_model->trade_address)
                <tr>
                    <td class="text-center ">
                        <strong>
                            {{ strtoupper($establish_model->description) }}
                        </strong>
                    </td>
                </tr>

                <tr>
                    <td class="text-center ">
                        {{ $establish_model->trade_address !== '-' ? $establish_model->trade_address : '' }}
                    </td>
                </tr>
            @endisset
        @endif
        <tr>
            <td class="text-center">{{ $establishment->email !== '-' ? 'Email: ' . $establishment->email : '' }}</td>
        </tr>
        <tr>
            <td class="text-center">
                <svg width="15px" height="15px" viewBox="0 0 24 24" version="1.1" id="svg8"
                    inkscape:version="0.92.4 (5da689c313, 2019-01-14)" sodipodi:docname="1881161.svg"
                    xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/"
                    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                    xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
                    <path id="path4" inkscape:connector-curvature="0"
                        d="M16.6,14c-0.2-0.1-1.5-0.7-1.7-0.8c-0.2-0.1-0.4-0.1-0.6,0.1c-0.2,0.2-0.6,0.8-0.8,1c-0.1,0.2-0.3,0.2-0.5,0.1c-0.7-0.3-1.4-0.7-2-1.2c-0.5-0.5-1-1.1-1.4-1.7c-0.1-0.2,0-0.4,0.1-0.5c0.1-0.1,0.2-0.3,0.4-0.4c0.1-0.1,0.2-0.3,0.2-0.4c0.1-0.1,0.1-0.3,0-0.4c-0.1-0.1-0.6-1.3-0.8-1.8C9.4,7.3,9.2,7.3,9,7.3c-0.1,0-0.3,0-0.5,0C8.3,7.3,8,7.5,7.9,7.6C7.3,8.2,7,8.9,7,9.7c0.1,0.9,0.4,1.8,1,2.6c1.1,1.6,2.5,2.9,4.2,3.7c0.5,0.2,0.9,0.4,1.4,0.5c0.5,0.2,1,0.2,1.6,0.1c0.7-0.1,1.3-0.6,1.7-1.2c0.2-0.4,0.2-0.8,0.1-1.2C17,14.2,16.8,14.1,16.6,14 M19.1,4.9C15.2,1,8.9,1,5,4.9c-3.2,3.2-3.8,8.1-1.6,12L2,22l5.3-1.4c1.5,0.8,3.1,1.2,4.7,1.2h0c5.5,0,9.9-4.4,9.9-9.9C22,9.3,20.9,6.8,19.1,4.9 M16.4,18.9c-1.3,0.8-2.8,1.3-4.4,1.3h0c-1.5,0-2.9-0.4-4.2-1.1l-0.3-0.2l-3.1,0.8l0.8-3l-0.2-0.3C2.6,12.4,3.8,7.4,7.7,4.9S16.6,3.7,19,7.5C21.4,11.4,20.3,16.5,16.4,18.9" />
                </svg>

                {{ $establishment->telephone !== '-' ? $establishment->telephone : '' }}
            </td>
        </tr>

        @isset($establishment->web_address)
            <tr>
                <td class="text-center">
                    {{ $establishment->web_address !== '-' ? 'Web: ' . $establishment->web_address : '' }}</td>
            </tr>
        @endisset

        @isset($establishment->aditional_information)
            <tr>
                <td class="text-center pb-3">
                    {{ $establishment->aditional_information !== '-' ? $establishment->aditional_information : '' }}</td>
            </tr>
        @endisset

        <tr>
            <td class="text-center pt-3 border-top">
                <h4>{{ $document->document_type->description }}</h4>
            </td>
        </tr>
        <tr>
            <td class="text-center pb-3 border-bottom">
                <h3>{{ $document_number }}</h3>
            </td>
        </tr>
    </table>
    <table class="full-width" style="margin-left:15px;margin-right:15px;">
        <tr>
            <td width="" class="pt-3">
                <p class="desc">F. Emisión:</p>
            </td>
            <td width="" class="pt-3">
                <p class="desc">{{ $document->date_of_issue }}</p>
            </td>
        </tr>

        <tr>
            <td width="">
                <p class="desc">H. Emisión:</p>
            </td>
            <td width="">
                <p class="desc">{{ $document->time_of_issue }}</p>
            </td>
        </tr>
        @isset($invoice->date_of_due)
            <tr>
                <td>
                    <p class="desc">F. Vencimiento:</p>
                </td>
                <td>
                    @php
                        $date_of_due = $invoice->date_of_due;
                        $date_of_due = Carbon\Carbon::parse($date_of_due)->format('Y-m-d');
                    @endphp
                    <p class="desc">{{ $date_of_due }}</p>
                </td>
            </tr>
        @endisset

        <tr>
            <td class="align-top">
                <p class="desc">Cliente:</p>
            </td>
            <td>
                <p class="desc">{{ $customer->name }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="desc">{{ $customer->identity_document_type->description }}:</p>
            </td>
            <td>
                <p class="desc">{{ $customer->number }}</p>
            </td>
        </tr>
        @isset($customer->telephone)
            <tr>
                <td>
                    <p class="desc">TELEFONO:</p>
                </td>
                <td>
                    <p class="desc">{{ $customer->telephone }}</p>
                </td>


            </tr>
        @endisset
        @if ($student_name)
            <tr>
                <td class="align-top">
                    <p class="desc">Alumno:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $student_name }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">Clase:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $class }}
                    </p>
                </td>
            </tr>
        @endif
        @if ($customer->address !== '')
            <tr>
                <td class="align-top">
                    <p class="desc">Dirección:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $customer->address }}
                        {{ $customer->district_id !== '-' ? ', ' . $customer->district->description : '' }}
                        {{ $customer->province_id !== '-' ? ', ' . $customer->province->description : '' }}
                        {{ $customer->department_id !== '-' ? '- ' . $customer->department->description : '' }}
                    </p>
                </td>
            </tr>
        @endif
        @if ($hotel_rent)
            @php
                $hotel_rent_items = $hotel_rent->items;
                
            @endphp
            @foreach ($hotel_rent_items as $hri)
                <tr>
                    <td>
                        <p class="desc">Habitación:</p>
                    </td>
                    <td>
                        <p class="desc">{{ $hri->table->number }}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="desc">Entrada:</p>

                    </td>
                    <td>
                        <p class="desc">
                            {{ \Carbon\Carbon::parse($hri->checkin_date)->format('d/m/Y') }} {{ $hri->checkin_time }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="desc">Salida:</p>

                    </td>
                    <td>
                        <p class="desc">
                            {{ \Carbon\Carbon::parse($hri->checkout_date)->format('d/m/Y') }}
                            {{ $hri->checkout_time }}
                        </p>
                    </td>
                </tr>
            @endforeach
        @endif
        @if ($hotel_rent_advance)
            @php
                $hotel_rent_items = $hotel_rent_advance->hotel_rent->items;
                
            @endphp
            @foreach ($hotel_rent_items as $hri)
                @if ($hri->is_reserve)
                    <tr>
                        <td>
                            <p class="desc">Habitación:</p>
                        </td>
                        <td>
                            <p class="desc">{{ $hri->table->number }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="desc">Reserva:</p>

                        </td>
                        <td>
                            <p class="desc">
                                {{ \Carbon\Carbon::parse($hri->checkin_date)->format('d/m/Y') }}
                                {{ $hri->checkin_time }}
                            </p>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if ($hotel_rent)
            @php
                $advances = $hotel_rent->documents->toArray();
                $observation_hotel = '';
                if (count($advances) > 0) {
                    $observation_hotel = 'Adelantos : ';
               
                    foreach($advances as $adv) {
                        $document_hotel =   $adv['document'] ?? $adv['sale_note'];
                        $full_number = $document_hotel["series"] . "-" . $document_hotel["number"];
                        $total = $document_hotel["total"];
                        $observation_hotel .=  ' ' . $full_number . ' S/' . $total . ' ';
                    }
                }
            @endphp
        @endif
        <tr>
            <td colspan="2" class="align-top">
                <b>Observación:</b> {{ trim($document->observation) }}

                @isset($document->additional_information)
                    @foreach ($document->additional_information as $information)
                        @if ($information)
                            {{ $information }}<br />
                        @endif
                    @endforeach
                @endisset
                @isset ($observation_hotel)
                    <br>
                    <b>{{ $observation_hotel }}</b>
                @endisset
            </td>
        </tr>

        @if ($document->detraction)
            {{-- <strong>Operación sujeta a detracción</strong> --}}
            <tr>
                <td class="align-top">
                    <p class="desc">N. Cta Detracciones:</p>
                </td>
                <td>
                    <p class="desc">{{ $document->detraction->bank_account }}</p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">B/S Sujeto a detracción:</p>
                </td>
                @inject('detractionType', 'App\Services\DetractionTypeService')
                <td>
                    <p class="desc">{{ $document->detraction->detraction_type_id }} -
                        {{ $detractionType->getDetractionTypeDescription($document->detraction->detraction_type_id) }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">Método de pago:</p>
                </td>
                <td>
                    <p class="desc">
                        {{ $detractionType->getPaymentMethodTypeDescription($document->detraction->payment_method_id) }}
                    </p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">Porcentaje detracción:</p>
                </td>
                <td>
                    <p class="desc">{{ $document->detraction->percentage }}%</p>
                </td>
            </tr>
            <tr>
                <td class="align-top">
                    <p class="desc">Monto detracción:</p>
                </td>
                <td>
                    <p class="desc">{{ $document->currency_type->symbol }} {{ $document->detraction->amount }}</p>
                </td>
            </tr>
            @if ($document->detraction->pay_constancy)
                <tr>
                    <td class="align-top">
                        <p class="desc">Constancia de pago:</p>
                    </td>
                    <td>
                        <p class="desc">{{ $document->detraction->pay_constancy }}</p>
                    </td>
                </tr>
            @endif
        @endif

        @if ($document->prepayments)
            @foreach ($document->prepayments as $p)
                <tr>
                    <td>
                        <p class="desc">Anticipo :</p>
                    </td>
                    <td>
                        <p class="desc">{{ $p->number }}</p>
                    </td>
                </tr>
            @endforeach
        @endif
        @if ($document->purchase_order)
            <tr>
                <td>
                    <p class="desc">Orden de Compra:</p>
                </td>
                <td>
                    <p class="desc">{{ $document->purchase_order }}</p>
                </td>
            </tr>
        @endif
        @isset($document->quotation->delivery_date)
            <tr>
                <td>
                    <p class="desc">F. Entrega</p>
                </td>
                <td>
                    <p class="desc">{{ $document->quotation->delivery_date }}</p>
                </td>
            </tr>
        @endisset
        @isset($document->quotation->sale_opportunity)
            <tr>
                <td>
                    <p class="desc">O. Venta</p>
                </td>
                <td>
                    <p class="desc">{{ $document->quotation->sale_opportunity->number_full }}</p>
                </td>
            </tr>
        @endisset
    </table>

    @if ($document->guides)
        {{-- <strong>Guías:</strong> --}}
        <table>
            @foreach ($document->guides as $guide)
                <tr>
                    @if (isset($guide->document_type_description))
                        <td class="desc">{{ $guide->document_type_description }}</td>
                    @else
                        <td class="desc">{{ $guide->document_type_id }}</td>
                    @endif
                    <td class="desc">:</td>
                    <td class="desc">{{ $guide->number }}</td>
                </tr>
            @endforeach
        </table>
    @endif


    @if (!is_null($document_base))
        <table>
            <tr>
                <td class="desc">Documento Afectado:</td>
                <td class="desc">{{ $affected_document_number }}</td>
            </tr>
            <tr>
                <td class="desc">Tipo de nota:</td>
                <td class="desc">
                    {{ $document_base->note_type === 'credit' ? $document_base->note_credit_type->description : $document_base->note_debit_type->description }}
                </td>
            </tr>
            <tr>
                <td class="align-top desc">Descripción:</td>
                <td class="text-left desc">{{ $document_base->note_description }}</td>
            </tr>
        </table>
    @endif

    <table class="full-width mt-10 mb-10" style="margin-left:15px;margin-right:15px;">
        <thead class="">
            <tr>
                <th class="border-top-bottom desc-9 text-left">CANT.</th>
                <th class="border-top-bottom desc-9 text-left">UNIDAD</th>
                <th class="border-top-bottom desc-9 text-left">DESCRIPCIÓN</th>
                <th class="border-top-bottom desc-9 text-left">P.UNIT</th>
                <th class="border-top-bottom desc-9 text-left">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($document->items as $row)
                <tr>
                    <td class="text-center desc-9 align-top">
                        @if ((int) $row->quantity != $row->quantity)
                            {{ number_format($row->quantity, 2) }}
                        @else
                            @if (isset($row->unit_qty))
                                {{ number_format($row->quantity, 2) }}
                            @else
                                {{ number_format($row->quantity, 2) }}
                            @endif
                        @endif
                    </td>
                    <td class="text-center desc-9 align-top">
                        {{ isset($row->item->has_unit_type) ? 'NIU' : $row->item->unit_type_id }}
                    </td>
                    <td class="text-left desc-9 align-top">
                        @if (isset($row->name_product_pdf))
                            {!! $row->name_product_pdf !!}
                        @else
                            @if (isset($row->item->description_internet))
                                {!! $row->item->description_internet !!}
                            @else
                                {!! $row->item->description !!}
                            @endif
                            @if (isset($row->item->lots))
                                @foreach ($row->item->lots as $lot)
                                    <br />{!! $lot->series !!}
                                @endforeach
                            @endif

                            @if (isset($row->item->second_name))
                                - {!! $row->item->second_name !!}
                            @endif
                            @if (isset($row->item->has_unit_type))
                                - {!! $row->item->has_unit_type !!}
                            @endif
                            @if (isset($row->unit_desc))
                                {!! $row->unit_desc !!}
                            @endif
                        @endif

                        @if (!empty($row->item->presentation))
                            {!! $row->item->presentation->description !!}
                        @endif

                        @foreach ($row->additional_information as $information)
                            @if ($information)
                                <br />{{ $information }}
                            @endif
                        @endforeach

                        @if ($row->attributes)
                            @foreach ($row->attributes as $attr)
                                <br />{!! $attr->description !!} : {{ $attr->value }}
                            @endforeach
                        @endif
                        @if ($row->discounts)
                            @foreach ($row->discounts as $dtos)
                                <br /><small>{{ $dtos->factor * 100 }}% {{ $dtos->description }}</small>
                            @endforeach
                        @endif

                        {{-- @if ($row->item->is_set == 1)
                            <br>
                            @inject('itemSet', 'App\Services\ItemSetService')

                            {{ join('-', $itemSet->getItemsSet($row->item_id)) }}
                        @endif --}}

                    </td>
                    <td class="text-right desc-9 align-top">

                        @if (isset($row->price_unit))
                            {{ number_format($row->price_unit, 2) }}
                        @else
                            {{ number_format($row->unit_price, 2) }}
                        @endif
                    </td>
                    <td class="text-right desc-9 align-top">{{ number_format($row->total, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="border-bottom"></td>
                </tr>
            @endforeach

            @if ($document->prepayments)
                @foreach ($document->prepayments as $p)
                    <tr>
                        <td class="text-center desc-9 align-top">
                            1
                        </td>
                        <td class="text-center desc-9 align-top">NIU</td>
                        <td class="text-left desc-9 align-top">
                            ANTICIPO: {{ $p->document_type_id == '02' ? 'FACTURA' : 'BOLETA' }} NRO.
                            {{ $p->number }}
                        </td>
                        <td class="text-right  desc-9 align-top">-{{ number_format($p->total, 2) }}</td>
                        <td class="text-right  desc-9 align-top">-{{ number_format($p->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="border-bottom"></td>
                    </tr>
                @endforeach
            @endif

            @if ($document->total_exportation > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. EXPORTACIÓN:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_exportation, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_free > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. GRATUITAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_free, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_unaffected > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. INAFECTAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_unaffected, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_exonerated > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. EXONERADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_exonerated, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_taxed > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">OP. GRAVADAS:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_taxed, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_discount > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">DESCUENTO TOTAL:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_discount, 2) }}</td>
                </tr>
            @endif
            @if ($document->total_plastic_bag_taxes > 0)
                <tr>
                    <td colspan="4" class="text-right font-bold desc">ICBPER:
                        {{ $document->currency_type->symbol }}</td>
                    <td class="text-right font-bold desc">{{ number_format($document->total_plastic_bag_taxes, 2) }}
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="4" class="text-right font-bold desc">IGV: {{ $document->currency_type->symbol }}
                </td>
                <td class="text-right font-bold desc">{{ number_format($document->total_igv, 2) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right font-bold desc">TOTAL A PAGAR:
                    {{ $document->currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total, 2) }}</td>
            </tr>


        </tbody>
    </table>
    <table class="full-width" style="margin-left:15px;margin-right:15px;">
        <tr>

            @foreach (array_reverse((array) $document->legends) as $row)
        <tr>
            @if ($row->code == '1000')
                <td class="desc pt-3">Son: <span class="font-bold">{{ $row->value }}
                        {{ $document->currency_type->description }}</span></td>
                @if (count((array) $document->legends) > 1)
        <tr>
            <td class="desc pt-3"><span class="font-bold">Leyendas</span></td>
        </tr>
        @endif
    @else
        <td class="desc pt-3">{{ $row->code }}: {{ $row->value }}</td>
        @endif

        </tr>
        @endforeach

        </tr>
        <tr>

            {{-- @if ($balance < 0)

                @php
                    $Total = $document->total + $paymet2;
                @endphp

                @foreach ($boxes as $box)
        <tr>
            <td colspan="4" class="text-left font-bold desc">Total {{ $box->method }}:
                {{ $document->currency_type->symbol }}</td>
            <td class="text-left font-bold desc">{{ number_format(abs($box->amount), 2, '.', '') }}</td>
        </tr>
        @endforeach --}}
            @if ($document->payment_condition_id == '01')
        <tr>
            <td colspan="4" class="text-left font-bold desc">VUELTO: {{ $document->currency_type->symbol }}
            </td>
            <td class="text-left font-bold desc">{{ number_format(abs($paymet2), 2, '.', '') }}</td>
        </tr>
        @endif
        {{-- @endif --}}
        </tr>

        <tr>
            <td colspan="4" class="text-left font-bold desc"><b>FORMA DE PAGO</b></td>
            <td class="text-left font-bold desc">{{ mb_strtoupper($document->payment_condition->name) }}</td>
        </tr>
        {{-- <tr>
            <td class="desc pt-3"><b>OBSERVACION:</b> {{ trim($document->observation) }}
            @isset($document->additional_information)
                @foreach ($document->additional_information as $information)
                    @if ($information)
                        {{ $information }}<br />
                    @endif
                @endforeach
            @endisset
            </td>
        </tr> --}}
        @if ($document->detraction)
            <tr>
                <td class="desc pt-3 font-bold">
                    Operación sujeta al Sistema de Pago de Obligaciones Tributarias
                </td>
            </tr>
        @endif

        {{-- <tr>
        <td class="desc pt-3">
            @foreach ($document->additional_information as $information)
                @if ($information)
                    @if ($loop->first)
                        <strong>Información adicional</strong>
                    @endif
                    <p>{{ $information }}</p>
                @endif
            @endforeach
            <br>
            @if (in_array($document->document_type->id, ['01', '03']))
                @foreach ($accounts as $account)
                    <span class="font-bold">{{$account->bank->description}}</span> {{$account->currency_type->description}} {{$account->number}}
                @endforeach
            @endif

        </td>
    </tr> --}}
        {{--     
    <tr>
        <td colspan="2" class="text-left pt-3" style="background:red;min-width: 250px;"><img class="qr_code" src="data:image/png;base64, {{ $document->qr }}" /></td>
        <td class="text-center desc">Código Hash: {{ $document->hash }}</td>
        <td>xd</td>
    </tr> --}}
        {{-- <tr>
        <td class="text-center desc">Código Hash: {{ $document->hash }}</td>
    </tr> --}}


        @if ($customer->department_id == 16)
            <tr>
                <td class="text-center desc pt-5">
                    Representación impresa del Comprobante de Pago Electrónico.
                    <br />Esta puede ser consultada en:
                    <br /> <b>{!! url('/buscar') !!}</b>
                    <br /> "Bienes transferidos en la Amazonía
                    <br />para ser consumidos en la misma
                </td>
            </tr>
        @endif
        {{-- <h3> $payments->count= {{ $payments->count() }} </h3> --}}
        @if ($document->payment_condition_id == '01')
            <tr>
                <td class="desc pt-5">
                    <strong>PAGOS:</strong>
                </td>
            </tr>
            @foreach ($boxes as $box)
                <tr>
                    <td colspan="4" class="text-left font-bold desc">{{ $box->method }}
                        @if ($box->bank_account_operation)
                            <br>
                            <small>N° Op: {{ $box->bank_account_operation }}</small>
                        @endif
                        @if ($box->operation_number)
                            <br>
                            <small>N° Operación: {{ $box->operation_number }}</small>
                        @endif
                        :
                        {{ $document->currency_type->symbol }}
                    </td>
                    <td valign='bottom' class="text-left font-bold desc">
                        {{ number_format(abs($box->amount), 2, '.', '') }}</td>
                </tr>
            @endforeach
            {{-- @foreach ($payments as $row)
                <tr>
                    <td class="desc">&#8226; {{ $row->payment_method_type->description }} -
                        {{ $row->reference ? $row->reference . ' - ' : '' }} {{ $document->currency_type->symbol }}
                        {{ $row->payment + $row->change }}</td>
                </tr>
            @endforeach --}}
        @endif
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
                        Monto: {{ $quote->currency_type->symbol }}{{ $quote->amount }}</td>
                </tr>
            @endforeach
        @endif


        {{-- <tr>
        <td class="desc pt-2">
        <strong>Vendedor:</strong> </td>
    </tr>
                <tr>
                    <td class="desc">{{ $document->user->name }}</td>
                </tr> --}}

        </tr>


    </table>
    <table class="full-width" style="margin-left:15px;margin-right:15px;">

        <tr>
            <td class="text-left" style="vertical-align: top;"><img style="width: 80px;"
                    src="data:image/png;base64, {{ $document->qr }}" /></td>
            <td class="text-left " style="vertical-align: top; padding-top:5px">
                <b>Código Hash</b>: {{ $document->hash }} <br>
                <b>Vendedor</b>: {{ $document->user->name }} <br>
            </td>

        </tr>
        <tr>
            <td colspan="6" class="text-center desc pt-3">Para consultar el comprobante ingresar a
                {!! url('/buscar') !!}</td>
        </tr>
    </table>
</body>

</html>
